<template>
  <div>
    <div class="container">
      <h3 class="text-center">Wiadomości</h3>
      <div class="messaging">
        <div class="inbox_msg">
          <div class="inbox_people">
            <div class="headind_srch">
              <div class="recent_heading">
                <h4 v-if="newMessage == false">Ostatnie</h4>
                <h4 v-else>Wszyscy użytkownicy</h4>
              </div>
              <div class="srch_bar">
                <div v-if="newMessage == false" class="stylish-input-group">
                  <a
                    @click.prevent="newmesseages"
                    class="btn btn new-message"
                    style="background:#05728f; color:#fff"
                  >
                    <i class="fa fa-envelope"></i> Wszyscy użytkownicy
                  </a>
                </div>
                <div v-else class="stylish-input-group">
                  <a
                    @click.prevent="ostatnie"
                    class="btn btn new-message"
                    style="background:#05728f; color:#fff"
                  >
                    <i class="fa fa-envelope"></i> Ostatnie wiaodmości
                  </a>
                </div>
              </div>
            </div>
            <div v-if="newMessage == false" class="inbox_chat">
              <div
                v-for="privateMsg in privateMsgs"
                :key="privateMsg.id"
                @click="messagess(privateMsg.id)"
                style="cursor: pointer;"
                class="chat_list"
                :class="{
                                    active_chat: privateMsg.id == selected
                                }"
              >
                <div class="chat_people">
                  <div class="chat_img">
                    <i class="fas fa-user-alt fa-3x"></i>
                  </div>
                  <div class="chat_ib">
                    <h5>
                      {{ privateMsg.email }}
                      <span class="chat_date">
                        {{
                        new Date(
                        privateMsg.updated_at
                        )
                        | dateFormat(
                        "MMM. DD HH:mm:ss",
                        dateFormatConfig
                        )
                        }}
                      </span>
                    </h5>
                    <p v-for="role in privateMsg.roles" :key="role.id">{{ role.name }}</p>
                    <countmessages-component :uzytkownik_id="privateMsg.id"></countmessages-component>
                  </div>
                </div>
              </div>
            </div>
            <div v-if="newMessage == true" class="inbox_chat">
              <div
                v-for="user in users"
                :key="user.id"
                @click="messagess(user.id)"
                style="cursor: pointer;"
                class="chat_list"
                :class="{ active_chat: user.id == selected }"
              >
                <div class="chat_people">
                  <div class="chat_img">
                    <i class="fas fa-user-alt fa-3x"></i>
                  </div>
                  <div class="chat_ib">
                    <h5>{{ user.email }}</h5>
                    <p v-for="role in user.roles" :key="role.id">{{ role.name }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="mesgs">
            <div class="msg_history">
              <div v-for="(singleMsg, i) in singleMsgs" :key="i">
                <div v-if="singleMsg.user_from === user_id">
                  <div class="outgoing_msg">
                    <div class="sent_msg">
                      <p>{{ singleMsg.msg }}</p>
                      <span class="time_date">
                        {{
                        new Date(
                        singleMsg.created_at
                        )
                        | dateFormat(
                        "HH:mm | MMM D",
                        dateFormatConfig
                        )
                        }}
                      </span>
                    </div>
                  </div>
                </div>
                <div v-else>
                  <div class="incoming_msg">
                    <div class="incoming_msg_img">
                      <i class="fas fa-user-alt fa-3x"></i>
                    </div>
                    <div class="received_msg">
                      <div class="received_withd_msg">
                        <p>{{ singleMsg.msg }}</p>
                        <span class="time_date">
                          {{
                          new Date(
                          singleMsg.created_at
                          )
                          | dateFormat(
                          "HH:mm | MMM D",
                          dateFormatConfig
                          )
                          }}
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="bg-light">
              <div v-if="newMessage == false" class="input-group">
                <input
                  type="text"
                  v-model="msgFrom"
                  placeholder="Napisz wiadomość"
                  aria-describedby="button-addon2"
                  class="form-control rounded-0 border-0 py-4 bg-light"
                  @keydown="inputHandler"
                />
                <div class="input-group-append">
                  <button
                    @click.prevent="sendMsg"
                    id="button-addon2"
                    type="submit"
                    class="btn btn-link"
                  >
                    <i class="fa fa-paper-plane"></i>
                  </button>
                </div>
              </div>
              <div v-if="newMessage == true" class="input-group">
                <input
                  type="text"
                  v-model="msgFrom"
                  placeholder="Napisz wiadomość"
                  aria-describedby="button-addon2"
                  class="form-control rounded-0 border-0 py-4 bg-light"
                  @keydown="inputHandlerr"
                />
                <div class="input-group-append">
                  <button id="button-addon2" type="submit" class="btn btn-link">
                    <i class="fa fa-paper-plane"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import VueFilterDateFormat from "vue-filter-date-format";

export default {
  props: ["user_id"],
  data() {
    return {
      dateFormatConfig: {
        dayOfWeekNames: [
          "Niedziela",
          "Poniedziałek",
          "Wtorek",
          "Środa",
          "Czwartek",
          "Piątek",
          "Sobota",
        ],
        dayOfWeekNamesShort: ["Ni", "Po", "Wt", "Śr", "Cz", "Pi", "So"],
        monthNames: [
          "Styczeń",
          "Luty",
          "Marzec",
          "Kwiecień",
          "Maj",
          "Czerwiec",
          "Lipiec",
          "Śierpień",
          "Wrzesień",
          "Pażdziernik",
          "Listopad",
          "Grudzień",
        ],
        monthNamesShort: [
          "Sty",
          "Lut",
          "Mar",
          "Kwi",
          "Maj",
          "Cze",
          "Lip",
          "Sie",
          "Wrz",
          "Paź",
          "Lis",
          "Gru",
        ],
      },
      isHidden: false,
      privateMsgs: [],
      singleMsgs: [],
      selected: undefined,
      msgFrom: "",
      newMessage: false,
      users: [],
    };
  },
  methods: {
    loadMessages() {
      axios
        .get("/getMessages")
        .then((response) => (this.privateMsgs = response.data));
    },
    loadUsers() {
      axios.get("/getUsers").then((response) => (this.users = response.data));
    },
    messagess(id) {
      this.selected = id;
      axios.get("/api/getMessages/" + id).then((response) => {
        console.log(response.data); // show if success
        this.singleMsgs = response.data;
        this.isHidden = true;
        // app.conID = response.data[0].conversation_id; //we are putting data into our posts array
      });
    },
    inputHandler(e) {
      if (e.keyCode === 13 && !e.shiftKey) {
        e.preventDefault();
        this.sendMsg();
      }
    },
    inputHandlerr(e) {
      if (e.keyCode === 13 && !e.shiftKey) {
        e.preventDefault();
        this.sendNewMsg();
      }
    },
    sendMsg() {
      if (this.msgFrom) {
        axios
          .post("/sendMessage", {
            conID: this.singleMsgs[0].conversation_id,
            msg: this.msgFrom,
          })
          .then((response) => {
            console.log(response.data); // show if success
            this.message = null;
            this.messagess(this.selected);
          })
          .catch(function (error) {
            console.log(error); // run if we have error
          });
      }
      this.msgFrom = "";
    },
    sendNewMsg() {
      if (this.msgFrom) {
        axios
          .post("/sendNewMessage", {
            user_id: this.selected,
            msg: this.msgFrom,
          })
          .then((response) => {
            console.log(response.data); // show if success

            if (response.status === 200) {
              this.singleMsgs = response.data;
            }
          })
          .catch(function (error) {
            console.log(error); // run if we have error
          });
      }
      this.msgFrom = "";
    },
    scrollToEnd() {
      var container = document.querySelector(".msg_history");
      var scrollHeight = container.scrollHeight;
      container.scrollTop = scrollHeight;
    },
    newmesseages() {
      this.newMessage = true;
      this.singleMsgs = [];
    },
    ostatnie() {
      this.newMessage = false;
    },
  },
  mounted() {
    Echo.private("message").listen("MessageEvent", (e) => {
      //this.singleMsgs.push(e.msgFrom);
      this.messagess(this.selected);
    });
  },
  created() {
    this.loadMessages();
    this.loadUsers();
  },
  updated() {
    this.scrollToEnd();
  },
};
</script>

<style>
.container {
  max-width: 1170px;
  margin: auto;
}

img {
  max-width: 100%;
}

.inbox_people {
  background: #f8f8f8 none repeat scroll 0 0;
  float: left;
  overflow: hidden;
  width: 40%;
  border-right: 1px solid #c4c4c4;
}

.inbox_msg {
  border: 1px solid #c4c4c4;
  clear: both;
  overflow: hidden;
}

.top_spac {
  margin: 20px 0 0;
}

.recent_heading {
  float: left;
  width: 40%;
}

.srch_bar {
  display: inline-block;
  text-align: right;
  width: 60%;
}

.headind_srch {
  padding: 10px 29px 10px 20px;
  overflow: hidden;
  border-bottom: 1px solid #c4c4c4;
}

.recent_heading h4 {
  color: #05728f;
  font-size: 21px;
  margin: auto;
}

.srch_bar input {
  border: 1px solid #cdcdcd;
  border-width: 0 0 1px 0;
  width: 80%;
  padding: 2px 0 4px 6px;
  background: none;
}

.srch_bar .input-group-addon button {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  padding: 0;
  color: #707070;
  font-size: 18px;
}

.srch_bar .input-group-addon {
  margin: 0 0 0 -27px;
}

.chat_ib h5 {
  font-size: 15px;
  color: #464646;
  margin: 0 0 8px 0;
}

.chat_ib h5 span {
  font-size: 13px;
  float: right;
}

.chat_ib p {
  font-size: 14px;
  color: #989898;
  margin: auto;
}

.chat_img {
  float: left;
  width: 11%;
}

.chat_ib {
  float: left;
  padding: 0 0 0 15px;
  width: 88%;
}

.chat_people {
  overflow: hidden;
  clear: both;
}

.chat_list {
  border-bottom: 1px solid #c4c4c4;
  margin: 0;
  padding: 18px 16px 10px;
}

.inbox_chat {
  height: 550px;
  overflow-y: scroll;
}

.active_chat {
  background: #ebebeb;
}

.incoming_msg_img {
  display: inline-block;
  width: 6%;
}

.received_msg {
  display: inline-block;
  padding: 0 0 0 10px;
  vertical-align: top;
  width: 92%;
}

.received_withd_msg p {
  background: #ebebeb none repeat scroll 0 0;
  border-radius: 3px;
  color: #646464;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
}

.time_date {
  color: #747474;
  display: block;
  font-size: 12px;
  margin: 8px 0 0;
}

.received_withd_msg {
  width: 57%;
}

.mesgs {
  float: left;
  padding: 30px 15px 0 25px;
  width: 60%;
}

.sent_msg p {
  background: #05728f none repeat scroll 0 0;
  border-radius: 3px;
  font-size: 14px;
  margin: 0;
  color: #fff;
  padding: 5px 10px 5px 12px;
  width: 100%;
}

.outgoing_msg {
  overflow: hidden;
  margin: 26px 0 26px;
}

.sent_msg {
  float: right;
  width: 46%;
}

.input_msg_write input {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  color: #4c4c4c;
  font-size: 15px;
  min-height: 48px;
  width: 100%;
}

.type_msg {
  border-top: 1px solid #c4c4c4;
  position: relative;
}

.msg_send_btn {
  background: #05728f none repeat scroll 0 0;
  border: medium none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  right: 0;
  top: 11px;
  width: 33px;
}

.messaging {
  padding: 0 0 50px 0;
}

.msg_history {
  height: 516px;
  overflow-y: auto;
}
</style>
