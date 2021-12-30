<template>
  <v-card class="mx-auto" max-width="500">
    <v-card-title class="profile-edit-title">
      <span class="title font-weight-light">Edit Profile</span>
    </v-card-title>
    <v-form ref="form" v-model="valid">
      <v-card-text>
        <div class="profile-edit-input">
          <v-text-field v-model="name" type="text" :rules="nameRules" hide-details="auto">
            <template #label>
              <span>Name</span>
              <span class="red--text">
                <strong>*</strong>
              </span>
            </template>
          </v-text-field>
        </div>
        <div class="profile-edit-input">
          <v-text-field v-model="email" type="text" :rules="emailRules" hide-details="auto">
            <template #label>
              <span>Email</span>
              <span class="red--text">
                <strong>*</strong>
              </span>
            </template>
          </v-text-field>
        </div>
        <div class="profile-edit-input">
          <v-select v-model="type" :rules="typeRules" :items="typeList">
            <template #label>
              <span>User Type</span>
              <span class="red--text">
                <strong>*</strong>
              </span>
            </template>
          </v-select>
        </div>
        <div class="profile-edit-input">
          <DateOfBirthPicker v-model="dob" />
        </div>
        <div class="profile-edit-input">
          <v-text-field
            v-model="phone"
            type="text"
            label="Phone"
            :rules="phoneRules"
            hide-details="auto"
          ></v-text-field>
        </div>
        <div>
          <v-textarea label="Address" :rules="addressRules" v-model="address" rows="2"></v-textarea>
        </div>
        <div>
          <v-file-input
            @change="handleProfileInput"
            show-size
            v-model="profile"
            :rules="profileRules"
            accept="image/png, image/jpeg"
          >
            <template #label>
              <span>New Profile</span>
            </template>
          </v-file-input>
          <v-row class="mx-auto">
            <img class="preview" id="profile-preview" />
          </v-row>
        </div>
      </v-card-text>
      <v-card-actions class="register-action">
        <v-dialog v-model="dialog" persistent max-width="600">
          <template v-slot:activator="{ on }">
            <v-btn :disabled="!valid" large color="success" class="mr-4" v-on="on">Edit</v-btn>
            <v-btn color="error" large class="mr-4" @click="resetForm">Clear</v-btn>
          </template>
          <v-card>
            <v-card-title class="headline">Edit Profile Confirmation</v-card-title>
            <v-card-text>
              <v-row>
                <v-col cols="4">
                  <span>Name :</span>
                </v-col>
                <v-col cols="8">
                  <span>{{name}}</span>
                  <div v-if="errors.name">
                    <div v-for="error in errors.name" :key="error">
                      <span class="red--text">{{error}}</span>
                    </div>
                  </div>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="4">
                  <span>Email :</span>
                </v-col>
                <v-col cols="8">
                  <span>{{email}}</span>
                  <div v-if="errors.email">
                    <div v-for="error in errors.email" :key="error">
                      <span class="red--text">{{error}}</span>
                    </div>
                  </div>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="4">
                  <span>User Type :</span>
                </v-col>
                <v-col cols="8">
                  <span>{{type}}</span>
                  <div v-if="errors.type">
                    <div v-for="error in errors.type" :key="error">
                      <span class="red--text">{{error}}</span>
                    </div>
                  </div>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="4">
                  <span>Date of Birth :</span>
                </v-col>
                <v-col cols="8">
                  <span>{{dob}}</span>
                  <div v-if="errors.dob">
                    <div v-for="error in errors.dob" :key="error">
                      <span class="red--text">{{error}}</span>
                    </div>
                  </div>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="4">
                  <span>Phone :</span>
                </v-col>
                <v-col cols="8">
                  <span>{{phone}}</span>
                  <div v-if="errors.phone">
                    <div v-for="error in errors.phone" :key="error">
                      <span class="red--text">{{error}}</span>
                    </div>
                  </div>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="4">
                  <span>Address :</span>
                </v-col>
                <v-col cols="8">
                  <span>{{address}}</span>
                  <div v-if="errors.address">
                    <div v-for="error in errors.address" :key="error">
                      <span class="red--text">{{error}}</span>
                    </div>
                  </div>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="4">
                  <span>Profile :</span>
                </v-col>
                <v-col cols="8">
                  <img class="preview" id="profile-confirm-preview" />
                </v-col>
              </v-row>
            </v-card-text>
            <v-card-actions class="register-action">
              <v-spacer></v-spacer>
              <v-btn :disabled="!valid" color="success" large @click="submitForm">Confirm</v-btn>
              <v-btn color="error" large @click="closeDialog">Cancel</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-card-actions>
    </v-form>
  </v-card>
</template>
<script src="../../services/user/profile-edit.js">
</script>
<style scoped>
@import "../../../css/user/profile-edit.css";
</style>