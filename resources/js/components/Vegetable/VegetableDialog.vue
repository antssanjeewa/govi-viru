<template>
  <v-dialog v-model="dialog" width="900" persistent scrollable>
    <v-card>
      <v-card-title :class="`${item.id ? 'grey' :'green'} darken-4 white--text`">
        <v-layout>
          {{item.id ? "Update":"Add New"}}
          <v-spacer></v-spacer>
          <v-btn icon @click="cancel">
            <v-icon color="white">close</v-icon>
          </v-btn>
        </v-layout>
      </v-card-title>
      <v-card-text class="mt-3">
        <v-form ref="form" :valid="valid">
          <v-layout wrap>
            <v-flex xs12 md6>
              <v-autocomplete
                prepend-icon="person"
                label="Farmer ID"
                v-model="item.farmerId"
                :search-input.sync="searchUser"
                :items="farmers.data"
                item-value="id"
                item-text="name"
              />
            </v-flex>
            <v-flex xs12 md6>
              <v-autocomplete
                prepend-icon="grid_on"
                label="Veg ID"
                v-model="item.vegId"
                :search-input.sync="searchCategory"
                :items="category.data"
                item-value="id"
                item-text="code"
              />
            </v-flex>
            <v-flex xs12 md6>
              <v-text-field prepend-icon="category" label="Grade" v-model="item.grade"></v-text-field>
            </v-flex>
            <v-flex xs12 md6>
              <v-text-field prepend-icon="show_chart" label="Rate" v-model="item.rate"></v-text-field>
            </v-flex>
            <v-flex xs12 md6>
              <v-text-field
                type="number"
                prepend-icon="score"
                label="Quentity"
                v-model="item.quantity"
              ></v-text-field>
            </v-flex>
            <v-flex xs12 md6>
              <v-text-field
                type="number"
                prepend-icon="score"
                label="Free Quentity"
                v-model="item.freeQuantity"
              ></v-text-field>
            </v-flex>
            <v-flex xs12 md6>
              <v-menu
                v-model="date1"
                :close-on-content-click="false"
                :nudge-right="40"
                transition="scale-transition"
                offset-y
                min-width="290px"
              >
                <template v-slot:activator="{ on }">
                  <v-text-field
                    v-model="item.date"
                    label="Date"
                    prepend-icon="event"
                    readonly
                    v-on="on"
                  ></v-text-field>
                </template>
                <v-date-picker v-model="item.date" @input="date1 = false"></v-date-picker>
              </v-menu>
            </v-flex>
          </v-layout>
        </v-form>
      </v-card-text>
      <v-divider></v-divider>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn text color="warning" @click="cancel">cancel</v-btn>
        <v-btn text color="success" @click="save">{{item.id ? 'Update' : 'save'}}</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data: () => ({
    valid: false,
    date1: false,
    searchCategory: "",
    searchUser: "",
    item: {
      id: "",
      vegId: "",
      grade: "",
      rate: "",
      quantity: "",
      date: null,
      freeQuantity: null,
      farmerId: ""
    }
  }),
  watch: {
    editItem(val) {
      val.id && Object.assign(this.item, val);
    },
    searchCategory(val) {
      this.categorySearch(val);
    },
    searchUser(val) {
      this.farmerSearch(val);
    }
  },
  computed: {
    ...mapGetters({
      dialog: "vegetable/getDialog",
      editItem: "vegetable/getEditItem",
      category: "category/getCategory",
      farmers: "user/getUserList"
    })
  },
  methods: {
    ...mapActions({
      toggleDialog: "vegetable/toggle_dialog",
      setEditItem: "vegetable/set_edit_item",
      addNewVege: "vegetable/add_new_vegetable",
      updateVege: "vegetable/update_vegetable",
      categorySearch: "category/search_category",
      farmerSearch: "user/farner_search",
      setMessage: "set_message"
    }),
    save() {
      if (this.$refs.form.validate()) {
        if (this.item.id) {
          this.updateVege(this.item).then(response => {
            this.setMessage(response);
            this.cancel();
          });
        } else {
          this.addNewVege(this.item).then(response => {
            this.setMessage(response);
            this.cancel();
          });
        }
      }
    },
    cancel() {
      this.toggleDialog();
      this.item = {
        id: "",
        vegId: "",
        grade: "",
        rate: "",
        quantity: "",
        date: null,
        freeQuantity: null,
        farmerId: ""
      };
      this.setEditItem(this.item);
    }
  }
};
</script>