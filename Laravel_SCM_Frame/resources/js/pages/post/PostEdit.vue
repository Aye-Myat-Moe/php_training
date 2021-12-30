<template>
  <v-card class="mx-auto" max-width="344">
    <v-card-title class="edit-post-title">
      <span class="title font-weight-light">Edit Post</span>
    </v-card-title>
    <v-form ref="form" v-model="valid">
      <v-card-text>
        <div class="edit-post-input">
          <v-text-field
            v-model="title"
            type="text"
            label="Title"
            :rules="titleRules"
            hide-details="auto"
          ></v-text-field>
        </div>
        <div>
          <v-textarea label="Description" :rules="descriptionRules" v-model="description" rows="2"></v-textarea>
        </div>
        <v-row class="mx-auto">
          <label class="status-lbl">Status :</label>
          <v-switch v-model="status"></v-switch>
        </v-row>
      </v-card-text>
      <v-card-actions class="edit-post-action">
        <v-dialog v-model="dialog" persistent max-width="600">
          <template v-slot:activator="{ on }">
            <v-btn :disabled="!valid" large color="success" class="mr-4" v-on="on">Edit</v-btn>
            <v-btn color="error" large class="mr-4" @click="resetForm">Clear</v-btn>
          </template>
          <v-card>
            <v-card-title class="headline">Edit Post Confirmation</v-card-title>
            <v-card-text>
              <v-row>
                <v-col cols="4">
                  <span>Title :</span>
                </v-col>
                <v-col cols="8">
                  <span>{{title}}</span>
                  <div v-if="errors.title">
                    <div v-for="error in errors.title" :key="error">
                      <span class="red--text">{{error}}</span>
                    </div>
                  </div>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="4">
                  <span>Description :</span>
                </v-col>
                <v-col cols="8">
                  <span>{{description}}</span>
                  <div v-if="errors.description">
                    <div v-for="error in errors.description" :key="error">
                      <span class="red--text">{{error}}</span>
                    </div>
                  </div>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="4">
                  <span>Status :</span>
                </v-col>
                <v-col cols="8">
                  <span v-if="status">{{statusList[1]}}</span>
                  <span v-if="!status">{{statusList[0]}}</span>
                  <div v-if="errors.status">
                    <div v-for="error in errors.status" :key="error">
                      <span class="red--text">{{error}}</span>
                    </div>
                  </div>
                </v-col>
              </v-row>
            </v-card-text>
            <v-card-actions class="edit-post-action">
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
<script src="../../services/post/post-edit.js">
</script>

<style scoped>
@import "../../../css/post/post-edit.css";
</style>