<template>
  <v-card class="mx-auto" max-width="344">
    <v-card-title class="upload-post-title">
      <span class="title font-weight-light">Post Upload</span>
    </v-card-title>
    <v-form ref="form" v-model="valid">
      <v-card-text>
        <div v-if="error" class="upload-error">
          <span class="red--text">{{error}}</span>
        </div>
        <div>
          <v-file-input show-size v-model="csvFile" :rules="csvFileRules" accept=".csv">
            <template #label>
              <span>CSV File</span>
              <span class="red--text">
                <strong>*</strong>
              </span>
            </template>
          </v-file-input>
        </div>
      </v-card-text>
      <v-card-actions class="upload-action">
        <v-btn :disabled="!valid" large color="success" class="mr-4" @click="submitForm">Upload</v-btn>
        <v-btn color="error" large class="mr-4" @click="resetForm">Clear</v-btn>
      </v-card-actions>
    </v-form>
  </v-card>
</template>
<script src="../../services/post/post-upload.js">
</script>
<style scoped>
@import "../../../css/post/post-upload.css";
</style>