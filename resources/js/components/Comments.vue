<template>
  <div>
    <div class="container">
      <section class="content-item" id="comments">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">
              <form v-if="user_id" method="POST" @submit.prevent="addComment()">
                <div>
                  <h3 class="pull-left">Nowy komentarz</h3>
                  <button type="submit" class="btn btn-success mb-1 float-right">Dodaj</button>
                </div>
                <fieldset>
                  <div class="row">
                    <div class="col-sm-3 col-lg-2 hidden-xs">
                      <i class="fas fa-user-alt fa-6x"></i>
                    </div>
                    <div class="form-group col-xs-12 col-sm-10 col-lg-10">
                      <textarea
                        v-model="form.comment"
                        class="form-control"
                        id="message"
                        placeholder="Komentarz.."
                        required
                      ></textarea>
                    </div>
                  </div>
                </fieldset>
              </form>
              <h6 v-else>Dodawanie komentarzy tylko dla zalogowanych użytkowników.</h6>
              <h3>{{ comments.length }} Comments</h3>
              <span v-for="(comment, ind) in comments" :key="ind" :index="ind">
                <!-- COMMENT 1 - START -->
                <div class="media">
                  <a class="pull-left" href="#">
                    <i class="fas fa-user-alt fa-6x"></i>
                  </a>
                  <div class="media-body">
                    <h4 class="media-heading">{{ comment.user.name }}</h4>
                    <p>{{ comment.comment }}</p>
                    <ul class="list-unstyled list-inline media-detail float-left">
                      <li>
                        <i class="fa fa-calendar"></i>
                        {{ comment.created_at }}
                      </li>
                    </ul>
                    <ul class="list-unstyled list-inline media-detail float-right">
                      <li>
                        <a v-if="comment.user.id === user_id" href="#" @click="editComment(ind)">
                          <i class="fas fa-edit"></i>
                        </a>
                        <a
                          v-if="comment.user.id === user_id || isadmin"
                          href="#"
                          @click="deleteComment(comment.id)"
                        >
                          <i class="fas fa-trash-alt"></i>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
                <!-- COMMENT 1 - END -->
              </span>
            </div>
          </div>
        </div>
      </section>
    </div>
    <div>
      <modal name="modal-edytuj-komentarz" height="auto" classes="demo-modal-class">
        <div
          id="exampleModal"
          tabindex="-1"
          role="dialog"
          aria-labelledby="exampleModalLabel"
          aria-hidden="true"
        >
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edytuj komentarz</h5>
                <button
                  @click.prevent="hidecomment"
                  type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-label="Close"
                >
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form>
                <div class="modal-body">
                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Komentarz:</label>
                    <textarea
                      class="form-control"
                      v-model="edit_comment.comment"
                      id="message"
                      placeholder="Komentarz.."
                      required
                    ></textarea>
                  </div>
                </div>
                <div class="modal-footer">
                  <button
                    @click.prevent="hidecomment"
                    type="button"
                    class="btn btn-secondary"
                    data-dismiss="modal"
                  >Zamknij</button>
                  <input type="submit" @click="updateComment" value="Zmień" class="btn btn-primary" />
                </div>
              </form>
            </div>
          </div>
        </div>
      </modal>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import Form from "vform";
import axios from "axios";

export default {
  props: ["repair", "user_id", "isadmin"],

  data() {
    return {
      comments: [],
      edit_comment: [],
      form: new Form({
        comment: ""
      })
    };
  },
  methods: {
    loadComments() {
      axios
        .get("/api/showComments/" + this.repair)
        .then(response => (this.comments = response.data));
    },
    addComment() {
      let formData = new FormData();
      formData.append("comment", this.form.comment);
      axios.post("/api/addComment/" + this.repair, formData).then(() => {
        Fire.$emit("AfterAddComent");
      });
      this.form.comment = "";
    },
    deleteComment(id) {
      Swal.fire({
        title: "Napewno chcesz usunąć komentarz ?",
        text: "Nie będzie można tego cofnąć.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Tak, usuń!"
      }).then(result => {
        if (result.value) {
          axios
            .delete("/api/deleteComment/" + id)
            .then(() => {
              Swal.fire("Komentarz został usunięty");
              Fire.$emit("AfterAddComent");
            })
            .catch(() => {
              Swal("Błąd!", "Coś poszło nie tak.", "Uwaga");
            });
        }
      });
    },
    editComment(ind) {
      this.$modal.show("modal-edytuj-komentarz");
      this.edit_comment = this.comments[ind];
    },
    updateComment() {
      var self = this;
      let formData = new FormData();
      formData.append("comment", this.edit_comment.comment);
      axios
        .post("/api/updateComment/" + this.edit_comment.id, formData)
        .then(function(response) {
          Fire.$emit("AfterAddComent");
          self.hidecomment("modal-edytuj-komentarz");
          //window.location.reload();
        });
    },
    hidecomment() {
      this.$modal.hide("modal-edytuj-komentarz");
    }
  },
  created() {
    this.loadComments();
    Fire.$on("AfterAddComent", () => {
      this.loadComments();
    });
  }
};
</script>

<style>
body {
  margin-top: 20px;
}

.content-item {
  padding: 30px 0;
  background-color: #ffffff;
}

.content-item.grey {
  background-color: #f0f0f0;
  padding: 50px 0;
  height: 100%;
}

.content-item h2 {
  font-weight: 700;
  font-size: 35px;
  line-height: 45px;
  text-transform: uppercase;
  margin: 20px 0;
}

.content-item h3 {
  font-weight: 400;
  font-size: 20px;
  color: #555555;
  margin: 10px 0 15px;
  padding: 0;
}

.content-headline {
  height: 1px;
  text-align: center;
  margin: 20px 0 70px;
}

.content-headline h2 {
  background-color: #ffffff;
  display: inline-block;
  margin: -20px auto 0;
  padding: 0 20px;
}

.grey .content-headline h2 {
  background-color: #f0f0f0;
}

.content-headline h3 {
  font-size: 14px;
  color: #aaaaaa;
  display: block;
}

#comments {
  box-shadow: 0 -1px 6px 1px rgba(0, 0, 0, 0.1);
  background-color: #ffffff;
}

#comments form {
  margin-bottom: 30px;
}

#comments .btn {
  margin-top: 7px;
}

#comments form fieldset {
  clear: both;
}

#comments form textarea {
  height: 100px;
}

#comments .media {
  border-top: 1px dashed #dddddd;
  padding: 20px 0;
  margin: 0;
}

#comments .media > .pull-left {
  margin-right: 20px;
}

#comments .media img {
  max-width: 100px;
}

#comments .media h4 {
  margin: 0 0 10px;
}

#comments .media h4 span {
  font-size: 14px;
  float: right;
  color: #999999;
}

#comments .media p {
  margin-bottom: 15px;
  text-align: justify;
}

#comments .media-detail {
  margin: 0;
}

#comments .media-detail li {
  color: #aaaaaa;
  font-size: 12px;
  padding-right: 10px;
  font-weight: 600;
}

#comments .media-detail a:hover {
  text-decoration: underline;
}

#comments .media-detail li:last-child {
  padding-right: 0;
}

#comments .media-detail li i {
  color: #666666;
  font-size: 15px;
  margin-right: 10px;
}
</style>
