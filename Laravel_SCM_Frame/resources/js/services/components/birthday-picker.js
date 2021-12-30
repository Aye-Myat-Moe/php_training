export default {
  props: {
    value: {
      type: String,
      default: ""
    }
  },
  data: () => ({
    date: null,
    menu: false
  }),
  computed: {
    selected: {
      get() {
        return this.value;
      },
      set(value) {
        this.$emit("input", value);
      }
    }
  },
  watch: {
    menu(val) {
      val && setTimeout(() => (this.$refs.picker.activePicker = "YEAR"));
    }
  }
};