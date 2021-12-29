<template>
  <v-menu
    ref="menu"
    v-model="menu"
    :close-on-content-click="false"
    transition="scale-transition"
    offset-y
    min-width="290px"
  >
    <template v-slot:activator="{ on }">
      <v-text-field
        v-model="selected"
        v-on:input="$emit('input', $event)"
        label="Date of Birth"
        prepend-icon="event"
        value
        readonly
        v-on="on"
      ></v-text-field>
    </template>
    <v-date-picker
      ref="picker"
      v-model="selected"
      @input="menu = false"
      :max="new Date().toISOString().substr(0, 10)"
      min="1950-01-01"
      no-title
    ></v-date-picker>
  </v-menu>
</template>
<script src="../services/components/birthday-picker.js">
</script>