<template>
  <v-card class="mx-auto" max-width="500">
    <v-card-title class="headline">User Profile</v-card-title>
    <v-card-text id="detail-dialog">
      <v-row>
        <v-col cols="4">
          <span>Name :</span>
        </v-col>
        <v-col cols="8">
          <span id="detail-name"></span>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="4">
          <span>Email :</span>
        </v-col>
        <v-col cols="8">
          <span id="detail-email"></span>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="4">
          <span>User Type :</span>
        </v-col>
        <v-col cols="8">
          <span id="detail-type"></span>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="4">
          <span>Date of Birth :</span>
        </v-col>
        <v-col cols="8">
          <span id="detail-dob"></span>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="4">
          <span>Phone :</span>
        </v-col>
        <v-col cols="8">
          <span id="detail-phone"></span>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="4">
          <span>Address :</span>
        </v-col>
        <v-col cols="8">
          <span id="detail-address"></span>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="4">
          <span>Profile :</span>
        </v-col>
        <v-col cols="8">
          <div>
            <div class="profile-box" id="loading-box"></div>
            <img class="preview" id="profile-preview" />
          </div>
        </v-col>
      </v-row>
    </v-card-text>
    <v-card-actions class="register-action">
      <v-spacer></v-spacer>
      <v-btn @click="editProfile" large color="primary">Edit Profile</v-btn>
      <v-btn @click="changePassword" text large color="primary">Change password?</v-btn>
    </v-card-actions>
  </v-card>
</template>
<script src="../../services/user/profile.js">
</script>
<style scoped>
@import "../../../css/user/profile.css";
</style>