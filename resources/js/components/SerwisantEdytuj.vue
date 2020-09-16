<template>
  <div class="container">
    <span v-if=" repair[0].status === 0">
      <button type="button" @click.prevent="show" class="btn btn-primary">Edytuj</button>
      <button type="button" @click="endRepair" class="btn btn-success">Przekaż do zaakceptowania</button>
    </span>
    <modal name="modal-edytuj-naprawe" height="auto" classes="demo-modal-class" @closed="Closed">
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
              <h5 class="modal-title" id="exampleModalLabel">Edytuj naprawę</h5>

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
            <form>
              <div v-for="(rep, ind) in repair" :key="ind" class="modal-body">
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Nazwa:</label>
                  <input
                    v-model="rep.name"
                    type="text"
                    name="name"
                    class="form-control"
                    id="recipient-name"
                  />
                  <span style="color:red" v-if="errors.name" class="error">{{errors.name[0]}}</span>
                </div>
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Opis:</label>
                  <textarea
                    v-model="rep.description"
                    class="form-control"
                    id="recipient-description"
                  ></textarea>
                  <span
                    style="color:red"
                    v-if="errors.description"
                    class="error"
                  >{{errors.description[0]}}</span>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <img width="150px" class="img-fluid d-block new2 mx-2" :src="rep.image" />
                    <div v-if="!isHidden" class="form-group-append">
                      <button
                        v-on:click="removeimage()"
                        class="btn btn-danger mx-2"
                        type="button"
                      >Usuń</button>
                    </div>
                  </div>
                  <div v-if="isHidden">
                    <label class="col-md-4 control-label" for="filebutton">Wybierz zdjęcie:</label>
                    <div class="col-md-4">
                      <input
                        v-on:change="onImageChange"
                        id="upload-file"
                        name="zdj"
                        class="input-file"
                        type="file"
                      />
                      <span style="color:red" v-if="errors.image" class="error">{{errors.image[0]}}</span>
                    </div>
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
                <input type="submit" @click="editRepair" value="Zmień" class="btn btn-primary" />
              </div>
            </form>
          </div>
        </div>
      </div>
    </modal>
  </div>
</template>

<script>
import Form from "vform";
import Vue from "vue";
import axios from "axios";
export default {
  props: ["repairedit"],

  data() {
    return {
      isHidden: false,
      repair: [
        {
          status: [],
        },
      ],
      name: "",
      description: "",
      image: "",
      errors: [],
      form: new FormData(),
    };
  },
  methods: {
    show() {
      this.$modal.show("modal-edytuj-naprawe");
    },
    hide() {
      this.$modal.hide("modal-edytuj-naprawe");
      this.errors = [];
      Fire.$emit("AfterLoadRepair");
    },
    editRepair(e) {
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
      formData.append("name", this.repair[0].name);
      formData.append("description", this.repair[0].description);

      axios
        .post("/api/serwisant/editRepair/" + this.repairedit, formData, config)
        .then(function (response) {
          currentObj.success = response.data.success;
          Fire.$emit("AfterLoadRepair");
          self.hide("modal-edytuj-naprawe");
          window.location.reload();
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          }
        });

      this.image = "";
      this.name = "";
      this.description = "";
    },
    onImageChange(e) {
      console.log(e.target.files[0]);
      this.image = e.target.files[0];
    },
    loadRepair() {
      axios
        .get("/api/serwisant/showRepair/" + this.repairedit)
        .then((response) => (this.repair = response.data))
        .catch((err) => {
          console.log(err.toJSON()); // Return error object
        });
    },
    removeimage: function () {
      this.repair[0].image = "";
      this.isHidden = true;
    },
    endRepair: function () {
      Swal.fire({
        title: "Na pewno chcesz zakończyć naprawę i przekazać do akceptacji ?",
        text: "Nie będzie można tego cofnąć.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Tak!",
      }).then((result) => {
        if (result.value) {
          axios
            .post("/api/serwisant/endRepair/" + this.repairedit)
            .then(() => {
              Swal.fire("Naprawa przekazana do akceptacji.");
              window.location.reload();
            })
            .catch(() => {
              Swal("Błąd!", "Coś poszło nie tak.", "Uwaga");
            });
        }
      });
    },
    Closed(event) {
      this.isHidden = false;
      Fire.$emit("AfterLoadRepair");
    },
  },
  created() {
    this.loadRepair();
    Fire.$on("AfterLoadRepair", () => {
      this.loadRepair();
    });
  },
};
</script>

<style>
</style>
