<template>
  <div>
    <div class="row">
      <div class="col-lg-12">
        <div class="float-right">
          <button @click.prevent="show" type="button" class="btn btn-success">Nowa naprawa</button>
        </div>
        <table class="table table-bordered table-striped">
          <thead>
            <tr class="text-center bg-info text-light">
              <th>Nazwa</th>
              <th>Serwisant</th>
              <th>Status</th>
              <th>Zaakceptowane</th>
              <th>Usuń</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="repair in repairs" :key="repair.id" class="text-center">
              <td>
                <a
                  :href="`/serwisant/naprawa/`+device+`/`+repair.id+`/`+repair.slugi_repair"
                >{{repair.name}}</a>
              </td>
              <td>{{repair.users.name}}</td>
              <td>
                <span v-if="repair.status === 0">W realizacji</span>
                <span v-else>Zakończone</span>
              </td>
              <td>
                <span v-if="repair.accept === 0">Nie</span>
                <span v-else>Tak</span>
              </td>
              <td>
                <a
                  v-if="repair.user_id === user_id || isadmin"
                  href="#"
                  @click="deleterepair(repair.id)"
                >
                  <button type="button" class="btn btn-danger">
                    <i class="far fa-trash-alt"></i>
                  </button>
                </a>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="card-footer"></div>
        <div class="col-12 d-flex justify-content-center"></div>
      </div>
    </div>
    <div>
      <modal name="modal-step" height="auto" classes="demo-modal-class" @closed="Closed">
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
                <h5 class="modal-title" id="exampleModalLabel">Nowa naprawa</h5>

                <button
                  @click.prevent="hide"
                  type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-label="Close"
                >
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="text-left" v-for="error in errors" :key="error.id">
                <ul v-for="err in error" :key="err.id">
                  <li class="text-danger">{{ err }}</li>
                </ul>
              </div>
              <form
                action="/api/serwisant/addRepair"
                enctype="multipart/form-data"
                @submit="addRepair"
              >
                <div class="modal-body">
                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Nazwa:</label>
                    <input
                      type="text"
                      v-model="name"
                      name="name"
                      class="form-control"
                      id="recipient-name"
                    />
                  </div>
                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Opis:</label>
                    <textarea v-model="description" class="form-control" id="recipient-description"></textarea>
                  </div>
                  <div class="form-group">
                    <label class="col-md-4 control-label" for="filebutton">Wybierz zdjęcie:</label>
                    <div class="col-md-4">
                      <input
                        v-on:change="onImageChange"
                        id="upload-file"
                        name="zdj"
                        class="input-file"
                        type="file"
                      />
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button
                    @click.prevent="hide"
                    type="button"
                    class="btn btn-secondary"
                    data-dismiss="modal"
                  >Zamknij</button>
                  <input type="submit" value="Dodaj" class="btn btn-primary" />
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
export default {
  props: ["device", "user_id", "isadmin"],
  data() {
    return {
      image: "",
      editmode: false,
      repairs: {},
      name: "",
      description: "",
      errors: [],
    };
  },
  methods: {
    addRepair(e) {
      this.errors = [];
      e.preventDefault();
      let currentObj = this;
      var self = this;

      const config = {
        headers: {
          "content-type": "multipart/form-data",
        },
      };

      let formData = new FormData();
      formData.append("image", this.image);
      formData.append("name", this.name);
      formData.append("description", this.description);

      axios
        .post("/api/serwisant/addRepair/" + this.device, formData, config)
        .then(function (response) {
          currentObj.success = response.data.success;
          Fire.$emit("AfterChange");
          self.hide("modal-step");
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          }
        });
    },
    onImageChange(e) {
      console.log(e.target.files[0]);
      this.image = e.target.files[0];
    },
    show() {
      this.$modal.show("modal-step");
    },
    hide() {
      this.$modal.hide("modal-step");
      this.errors = [];
      this.image = "";
      this.name = "";
      this.description = "";
    },
    Closed(event) {
      this.errors = [];
      this.image = "";
      this.name = "";
      this.description = "";
    },
    loadRepairs() {
      axios
        .get("/api/serwisant/showRepairs/" + this.device)
        .then((response) => (this.repairs = response.data));
    },
    deleterepair(id) {
      Swal.fire({
        title: "Na pewno chcesz usunąc naprawę ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Tak!",
      }).then((result) => {
        if (result.value) {
          axios
            .delete("/api/deleteRepair/" + id)
            .then(() => {
              Fire.$emit("AfterChange");
            })
            .catch(() => {
              Swal("Błąd!", "Coś poszło nie tak.", "Uwaga");
            });
        }
      });
    },
  },
  created() {
    this.loadRepairs();
    Fire.$on("AfterChange", () => {
      this.loadRepairs();
    });
  },
};
</script>

<style>
</style>
