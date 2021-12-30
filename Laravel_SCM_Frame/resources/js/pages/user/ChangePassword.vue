<template>
  <v-card class="mx-auto" max-width="500">
    <v-card-title class="change-password-title">
      <span class="title font-weight-light">User Change Password</span>
    </v-card-title>
    <v-form ref="form" v-model="valid">
      <v-card-text class="change-password-content">
        <div v-if="errors.current_password" class="reset-error">
          <div v-for="error in errors.current_password" :key="error">
            <span class="red--text">{{error}}</span>
          </div>
        </div>
        <div class="change-password-input">
          <v-text-field
            v-model="oldPassword"
            type="password"
            :rules="oldPwdRules"
            hide-details="auto"
          >
            <template #label>
              <span>Old Password</span>
              <span class="red--text">
                <strong>*</strong>
              </span>
            </template>
          </v-text-field>
        </div>
        <div class="change-password-input">
          <v-text-field
            v-model="newPassword"
            type="password"
            :rules="newPwdRules"
            hide-details="auto"
          >
            <template #label>
              <span>New Password</span>
              <span class="red--text">
                <strong>*</strong>
              </span>
            </template>
          </v-text-field>
        </div>
        <div class="register-input">
          <v-text-field
            v-model="confirmNewPassword"
            type="password"
            :rules="confirmNewPwdRules"
            hide-details="auto"
          >
            <template #label>
              <span>Confirm New Password</span>
              <span class="red--text">
                <strong>*</strong>
              </span>
            </template>
          </v-text-field>
        </div>
      </v-card-text>
      <v-card-actions class="register-action">
        <v-btn :disabled="!valid" large color="success" class="mr-4" @click="submitForm">Change</v-btn>
        <v-btn color="error" large class="mr-4" @click="resetForm">Clear</v-btn>
      </v-card-actions>
    </v-form>
  </v-card>
</template>
<script src="../../services/user/change-password.js">
</script>
<style scoped>
@import "../../../css/user/change-password.css";
</style>