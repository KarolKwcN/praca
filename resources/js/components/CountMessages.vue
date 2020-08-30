<template>
  <span style="float:right" class="chat_date">{{count}} nowych wiadomości</span>
</template>


<script>
import axios from "axios";

export default {
  props: ["uzytkownik_id"],
  data() {
    return {
      count: "",
    };
  },
  methods: {
    loadCounts() {
      axios
        .get("/api/countmessages/" + this.uzytkownik_id)
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