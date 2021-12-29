<template>
  <v-card>
    <v-card-title>
      Post list
      <v-spacer></v-spacer>
      <v-form ref="form">
        <v-row class="filter-bar">
          <v-col md="2.5">
            <v-text-field v-model="keyword" label="Search keyword" hide-details="auto"></v-text-field>
          </v-col>
          <v-btn
            class="post-list-btn mr-4"
            :disabled="!valid"
            color="primary"
            @click="filterPosts"
          >Filter</v-btn>
          <v-btn
            class="post-list-btn mr-4"
            color="primary"
            v-if="isLoggedIn"
            @click="createPost"
          >Create</v-btn>
          <v-btn class="post-list-btn mr-4" color="primary" v-if="isLoggedIn" @click="uploadPost">Upload</v-btn>
          <v-btn class="post-list-btn mr-4" color="primary" href="/post/download/" download>Download</v-btn>
        </v-row>
      </v-form>
    </v-card-title>
    <v-container>
      <v-data-table :headers="headers" :items="showList">
        <template v-slot:item.title="{ item }">
          <a v-if="item.title" @click.stop="showPostDetail(item)">{{item.title}}</a>
        </template>
        <template v-slot:item.operation="{ item }" v-if="isLoggedIn">
          <v-row>
            <div class="operation-btn">
              <v-btn color="primary" class="post-list-btn" @click="showPostEdit(item.id)">Edit</v-btn>
            </div>
            <div class="operation-btn">
              <v-btn color="error" class="post-list-btn" @click="showPostDeleteDialog(item)">Delete</v-btn>
            </div>
          </v-row>
        </template>
      </v-data-table>
      <v-dialog v-model="dialog" persistent max-width="600">
        <v-card>
          <v-card-title class="headline">{{dialogTitle}}</v-card-title>
          <v-card-text id="detail-dialog">
            <v-row class="detail-row">
              <v-col cols="4">
                <span>Title :</span>
              </v-col>
              <v-col cols="8">
                <span id="detail-title"></span>
              </v-col>
            </v-row>
            <v-row class="detail-row">
              <v-col cols="4">
                <span>Description :</span>
              </v-col>
              <v-col cols="8">
                <span id="detail-description"></span>
              </v-col>
            </v-row>
            <v-row class="detail-row">
              <v-col cols="4">
                <span>Status :</span>
              </v-col>
              <v-col cols="8">
                <span id="detail-status"></span>
              </v-col>
            </v-row>
            <v-row class="detail-row">
              <v-col cols="4">
                <span>Posted Date :</span>
              </v-col>
              <v-col cols="8">
                <span id="detail-posted-date"></span>
              </v-col>
            </v-row>
            <v-row class="detail-row">
              <v-col cols="4">
                <span>Posted User :</span>
              </v-col>
              <v-col cols="8">
                <span id="detail-posted-user"></span>
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
          </v-card-text>
          <v-card-actions class="register-action">
            <v-spacer></v-spacer>
            <v-btn color="error" v-if="isDeleteDialog" large @click="deletePost">Delete</v-btn>
            <v-btn color="primary" large @click="closeDialog">Cancel</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-container>
  </v-card>
</template>
<script src="../../services/post/post-list.js">
</script>
<style scoped>
@import "../../../css/post/post-list.css";
</style>