<template>
  <span style=" position: relative;  
                                left:-7px">{{count}}</span>
</template>


<script>
import axios from "axios";

export default {
  data() {
    return {
      count: "",
      timer: "",
    };
  },
  methods: {
    loadCounts() {
      axios
        .get("/api/messagecount")
        .then((response) => (this.count = response.data));
    },
  },
  created() {
    this.loadCounts();
  },
  mounted() {
    Echo.private("count").listen("MessageCount", (e) => {
      this.loadCounts();
    });
  },
};
</script>

<style>
</style>