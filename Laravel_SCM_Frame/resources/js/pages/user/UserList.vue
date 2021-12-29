<template>
  <v-card>
    <v-card-title>
      User List
      <v-spacer></v-spacer>
      <v-form ref="form">
        <v-row class="filter-bar">
          <v-col md="2.5">
            <v-text-field v-model="name" label="User Name" hide-details="auto"></v-text-field>
          </v-col>
          <v-col md="2.5">
            <v-text-field v-model="email" label="User Email" hide-details="auto"></v-text-field>
          </v-col>
          <v-col md="2.5">
            <v-menu v-model="fromMenu" :close-on-content-click="true">
              <template v-slot:activator="{ on }">
                <v-text-field
                  v-model="fromDate"
                  label="Created From"
                  prepend-icon="event"
                  readonly
                  v-on="on"
                  hide-details="auto"
                ></v-text-field>
              </template>
              <v-date-picker v-model="fromDate" @input="fromMenu = false"></v-date-picker>
            </v-menu>
          </v-col>
          <v-col md="2.5">
            <v-menu v-model="toMenu" :close-on-content-click="true">
              <template v-slot:activator="{ on }">
                <v-text-field
                  v-model="toDate"
                  label="Created From"
                  prepend-icon="event"
                  readonly
                  v-on="on"
                  hide-details="auto"
                ></v-text-field>
              </template>
              <v-date-picker v-model="toDate" @input="toMenu = false"></v-date-picker>
            </v-menu>
          </v-col>
          <v-btn
            :disabled="!valid"
            color="primary"
            class="user-list-btn mr-4"
            large
            @click="filterUsers"
          >Filter</v-btn>
        </v-row>
        <div class="filter-error" v-if="!valid">
          <span class="red--text">The 'Created From' field must be less than the 'Created To' field.</span>
        </div>
      </v-form>
    </v-card-title>
    <v-container>
      <v-data-table :headers="headers" :items="showList">
        <template v-slot:item.name="{ item }">
          <a v-if="item.name" @click.stop="showUserDetail(item)">{{item.name}}</a>
        </template>
        <template v-slot:item.type="{ item }">
          <span v-if="item.type">{{typeList[item.type]}}</span>
        </template>
        <template v-slot:item.dob="{ item }">
          <span v-if="item.dob">{{moment(item.dob).format("YYYY/MM/DD")}}</span>
        </template>
        <template v-slot:item.created_at="{ item }">
          <span v-if="item.created_at">{{moment(item.created_at).format("YYYY/MM/DD")}}</span>
        </template>
        <template v-slot:item.updated_at="{ item }">
          <span v-if="item.updated_at">{{moment(item.updated_at).format("YYYY/MM/DD")}}</span>
        </template>
        <template v-slot:item.operation="{ item }">
          <v-btn
            color="error"
            class="user-list-btn"
            v-if="userId != item.id"
            @click="showUserDeleteDialog(item)"
          >Delete</v-btn>
        </template>
      </v-data-table>
      <v-dialog v-model="dialog" persistent max-width="600">
        <v-card>
          <v-card-title class="headline">{{dialogTitle}}</v-card-title>
          <v-card-text id="detail-dialog">
            <v-row class="detail-row">
              <v-col cols="4">
                <span>Name :</span>
              </v-col>
              <v-col cols="8">
                <span id="detail-name"></span>
              </v-col>
            </v-row>
            <v-row class="detail-row">
              <v-col cols="4">
                <span>Email :</span>
              </v-col>
              <v-col cols="8">
                <span id="detail-email"></span>
              </v-col>
            </v-row>
            <v-row class="detail-row">
              <v-col cols="4">
                <span>User Type :</span>
              </v-col>
              <v-col cols="8">
                <span id="detail-type"></span>
              </v-col>
            </v-row>
            <v-row class="detail-row">
              <v-col cols="4">
                <span>Date of Birth :</span>
              </v-col>
              <v-col cols="8">
                <span id="detail-dob"></span>
              </v-col>
            </v-row>
            <v-row class="detail-row">
              <v-col cols="4">
                <span>Phone :</span>
              </v-col>
              <v-col cols="8">
                <span id="detail-phone"></span>
              </v-col>
            </v-row>
            <v-row class="detail-row">
              <v-col cols="4">
                <span>Address :</span>
              </v-col>
              <v-col cols="8">
                <span id="detail-address"></span>
              </v-col>
            </v-row>
            <v-row class="detail-row">
              <v-col cols="4">
                <span>Created Date :</span>
              </v-col>
              <v-col cols="8">
                <span id="detail-created-date"></span>
              </v-col>
            </v-row>
            <v-row class="detail-row">
              <v-col cols="4">
                <span>Created User :</span>
              </v-col>
              <v-col cols="8">
                <span id="detail-created-user"></span>
              </v-col>
            </v-row>
            <v-row class="detail-row">
              <v-col cols="4">
                <span>Updated Date :</span>
              </v-col>
              <v-col cols="8">
                <span id="detail-updated-date"></span>
              </v-col>
            </v-row>
            <v-row class="detail-row">
              <v-col cols="4">
                <span>Updated User :</span>
              </v-col>
              <v-col cols="8">
                <span id="detail-updated-user"></span>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="4">
                <span>Profile :</span>
              </v-col>
              <v-col cols="8">
                <img class="preview" id="profile-preview" />
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions class="register-action">
            <v-spacer></v-spacer>
            <v-btn color="error" v-if="isDeleteDialog" large @click="deleteUser">Delete</v-btn>
            <v-btn color="primary" large @click="closeDialog">Cancel</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-container>
  </v-card>
</template>
<script src="../../services/user/user-list.js">
</script>

<style scoped>
@import "../../../css/user/user-list.css";
</style>