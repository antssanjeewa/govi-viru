<template>
  <v-container>
    <v-layout class="display-4 mt-5" justify-center>Govi Viru Application</v-layout>
    <v-divider />
    <v-layout justify-space-around mt-5>
      <v-flex xs12 md2 v-for="item in items" :key="item.text">
      <v-sheet elevation="5">
          <v-layout>
            <v-flex :class="`${item.color} text-center`" xs4>
              <v-icon x-large color="white" class="my-6">{{item.icon}}</v-icon>
            </v-flex>
            <v-spacer/>
            <v-flex xs6 pa-3 mx-auto>
              <v-flex class="display-2">{{item.value}}</v-flex>
              <v-flex>{{item.text}}</v-flex>
            </v-flex>
          </v-layout>
      </v-sheet>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    items:[
      {text:'Farmers', value:'23',color:'red',icon:'people'},
      {text:'Vege', value:'03',color:'green',icon:'home'},
      {text:'Users', value:'01',color:'blue',icon:'people'},
    ]
  })
};
</script>