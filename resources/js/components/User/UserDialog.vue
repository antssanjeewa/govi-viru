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
      <v-card-text class="pt-4">
        <v-form ref="form" v-model="valid" lazy-validation>
          <v-layout wrap>
            <v-flex xs12 md8>
              <v-text-field
                label="Name"
                v-model="item.name"
                prepend-icon="person"
                color="green"
                :rules="[rules.required]"
              />
            </v-flex>
            <v-flex xs12 md4>
              <v-select
                label="role"
                v-model="item.role"
                :items="roles"
                item-value="id"
                item-text="name"
                prepend-icon="person"
                color="green"
                :rules="[rules.required]"
              />
            </v-flex>
            <v-flex xs12 md6>
              <v-text-field
                label="lat"
                v-model="item.lat"
                prepend-icon="person"
                color="green"
                :rules="[rules.required]"
              />
            </v-flex>
            <v-flex xs12 md6>
              <v-text-field
                label="long"
                v-model="item.long"
                prepend-icon="person"
                color="green"
                :rules="[rules.required]"
              />
            </v-flex>
            <v-flex xs12>
              <v-text-field
                label="address"
                v-model="item.address"
                prepend-icon="person"
                color="green"
                :rules="[rules.required]"
              />
            </v-flex>
            <v-flex xs12 md6>
              <v-text-field
                label="phoneNo"
                v-model="item.phoneNo"
                prepend-icon="person"
                color="green"
                :rules="[rules.required]"
              />
            </v-flex>
            <v-flex xs12 md6>
              <v-text-field
                label="whatsappNo"
                v-model="item.whatsappNo"
                prepend-icon="person"
                color="green"
                :rules="[rules.required]"
              />
            </v-flex>
            <v-flex xs12 md6>
              <v-text-field
                label="email"
                v-model="item.email"
                prepend-icon="person"
                color="green"
                :rules="[rules.required]"
              />
            </v-flex>
            <v-flex xs12 md6 v-if="!item.id">
              <v-text-field
                label="Password"
                v-model="item.password"
                prepend-icon="person"
                color="green"
                :rules="[rules.required]"
              />
            </v-flex>
          </v-layout>
        </v-form>
      </v-card-text>
      <v-divider></v-divider>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="warning" text @click="cancel">cancel</v-btn>
        <v-btn color="success" text @click="save">save</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data: () => ({
    valid: false,
    item: {
      id:'',
      name: "",
      lat: 0,
      long: 0,
      address: "",
      phoneNo: "",
      whatsappNo: "",
      role: "",
      email: ""
    },
    rules: {
      required: v => !!v || "This is required"
    }
  }),
  watch: {
    editItem(val) {
      this.changeItem(val)
    }
  },
  computed: {
    ...mapGetters({
      dialog: "user/getDialog",
      editItem: "user/getEditItem",
      roles: "role/getRoles"
    }),

  },
  methods: {
    ...mapActions({
      setDialog: "user/toggle_dialog",
      setEditItem: "user/set_edit_item",
      addNewUser: "user/add_new_user",
      updateUser: "user/update_user",
      getRoles: "role/get_active_roles",
      setMessage:'set_message'
    }),
    changeItem(val){
      this.getRoles()
      if(val.id){
        Object.assign(this.item, val);
      } 
    },
    save() {
      if (this.$refs.form.validate()) {
        if (this.item.id) {
          this.updateUser(this.item).then(response=>{
            this.setMessage(response)
            this.cancel()
          }); 
        } else {
          this.addNewUser(this.item).then(response=>{
            this.setMessage(response)
            this.cancel()
          }); 
        }
      }else{
        console.log("validate")
      }
    },
    cancel() {
      this.setDialog();
      this.$refs.form.resetValidation();
      this.item = {
        id:'',
        name: "",
        lat: 0,
        long: 0,
        address: "",
        phoneNo: "",
        whatsappNo: "",
        role: "",
        email: ""
      };
      this.setEditItem(this.item)
    }
  }
};
</script>