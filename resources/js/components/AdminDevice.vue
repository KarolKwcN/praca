<template>
  <div>
    <div class="row">
      <div class="col-lg-12">
        <div class="float-right">
          <button type="button" @click.prevent="show" class="btn btn-success">Dodaj model</button>
        </div>
        <table class="table table-bordered table-striped">
          <thead>
            <tr class="text-center bg-info text-light">
              <th>Model</th>
              <th>Opis</th>
              <th>Edytuj</th>
              <th>Usuń</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(device, ind) in devices.data" :key="ind" class="text-center">
              <td>
                <a
                  :href="`/admin/naprawy/`+device.brand.category.slug+`/`+device.brand.slugi+`/`+device.slugii"
                >{{device.name}}</a>
              </td>
              <td>{{device.description}}</td>
              <td>
                <button @click="editDevice(ind)" type="button" class="btn btn-info">
                  <i class="fas fa-edit"></i>
                </button>
              </td>
              <td>
                <button @click="deleteDevice(device.id)" type="button" class="btn btn-danger">
                  <i class="far fa-trash-alt"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="card-footer">
          <pagination :data="devices" @pagination-change-page="getResults"></pagination>
        </div>
      </div>
    </div>
    <div>
      <modal name="modal-step" height="auto" classes="demo-modal-class">
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
                <h5 class="modal-title" id="exampleModalLabel">Nowe urządzenie</h5>
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
              <form enctype="multipart/form-data" method="POST" @submit.prevent="addDevice()">
                <div class="modal-body">
                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Urządzenie:</label>
                    <input
                      type="text"
                      v-model="form.name"
                      name="name"
                      class="form-control"
                      id="recipient-name"
                    />
                    <span style="color:red" v-if="errors.name" class="error">{{errors.name[0]}}</span>
                  </div>
                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Opis:</label>
                    <textarea
                      v-model="form.description"
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
                    <label class="col-md-4 control-label" for="filebutton">Wybierz zdjęcie:</label>
                    <div class="col-md-4">
                      <input
                        @change="onImageChange"
                        id="upload-file"
                        name="image"
                        class="input-file"
                        type="file"
                      />
                      <span style="color:red" v-if="errors.image" class="error">{{errors.image[0]}}</span>
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
    <div>
      <modal name="modal-edytuj-urzadzenie" height="auto" classes="demo-modal-class">
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
                <h5 class="modal-title" id="exampleModalLabel">Edytuj</h5>
                <button
                  @click.prevent="hideedit"
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
                    <label for="recipient-name" class="col-form-label">Nazwa urzadzenia:</label>
                    <input
                      type="text"
                      v-model="edit_device.name"
                      name="name"
                      class="form-control"
                      id="recipient-name"
                    />
                    <span style="color:red" v-if="errors.name" class="error">{{errors.name[0]}}</span>
                  </div>
                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Opis:</label>
                    <textarea
                      v-model="edit_device.description"
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
                    <div v-if="!isHidden" class="input-group">
                      <img
                        width="150px"
                        class="img-fluid d-block new2 mx-2"
                        :src="edit_device.image"
                      />
                      <div class="form-group-append">
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
                          v-on:change="onImageChangee"
                          id="upload-file"
                          name="zdj"
                          class="input-file"
                          type="file"
                        />
                        <span
                          style="color:red"
                          v-if="errors.image"
                          class="error"
                        >{{errors.image[0]}}</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button
                    @click.prevent="hideedit"
                    type="button"
                    class="btn btn-secondary"
                    data-dismiss="modal"
                  >Zamknij</button>
                  <input type="submit" @click="updateDevice" value="Zmień" class="btn btn-primary" />
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
export default {
  props: ["brand"],
  data() {
    return {
      isHidden: false,
      devices: {},
      edit_device: [],
      form: new Form({
        id: "",
        name: "",
        description: "",
        image: null,
      }),
      errors: [],
    };
  },
  methods: {
    onImageChange(e) {
      this.form.image = e.target.files[0];
    },
    onImageChangee(e) {
      this.edit_device.image = e.target.files[0];
    },
    updateDevice(e) {
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
      formData.append("image", this.edit_device.image);
      formData.append("name", this.edit_device.name);
      formData.append("description", this.edit_device.description);

      axios
        .post(
          "/api/admin/updateDevice/" + this.edit_device.id,
          formData,
          config
        )
        .then(function (response) {
          currentObj.success = response.data.success;
          Fire.$emit("AfterDelete");
          self.hideedit("modal-edytuj-urzadzenie");
          //window.location.reload();
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          }
        });
    },
    editDevice(ind) {
      this.isHidden = false;
      this.$modal.show("modal-edytuj-urzadzenie");
      this.edit_device = this.devices.data[ind];
    },
    removeimage: function () {
      this.edit_device.image = "";
      this.isHidden = true;
    },
    addDevice() {
      this.errors = [];
      let formData = new FormData();
      formData.append("image", this.form.image);
      formData.append("name", this.form.name);
      formData.append("description", this.form.description);
      axios
        .post("/api/admin/addDevice/" + this.brand, formData)
        .then(() => {
          Fire.$emit("AfterDelete");
          this.$modal.hide("modal-step");
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          }
        });
    },
    deleteDevice(id) {
      Swal.fire({
        title: "Napewno chcesz usunąć model ?",
        text: "Nie będzie można tego cofnąć.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Tak, usuń!",
      }).then((result) => {
        if (result.value) {
          axios
            .delete("/api/admin/deleteDevice/" + id)
            .then(() => {
              Swal.fire("Model został usunięty");
              Fire.$emit("AfterDelete");
            })
            .catch(() => {
              Swal("Błąd!", "Coś poszło nie tak.", "Uwaga");
            });
        }
      });
    },
    show() {
      this.editmode = false;
      this.form.reset();
      this.$modal.show("modal-step");
    },
    hide() {
      this.errors = [];
      this.$modal.hide("modal-step");
    },
    hideedit() {
      this.errors = [];
      this.$modal.hide("modal-edytuj-urzadzenie");
      Fire.$emit("AfterDelete");
    },
    loadDevices() {
      axios
        .get("/api/admin/showDevices/" + this.brand)
        .then((response) => (this.devices = response.data));
    },
    getResults(page = 1) {
      axios
        .get("/api/admin/showDevices/" + this.brand + "?page=" + page)
        .then((response) => {
          this.devices = response.data;
        });
    },
  },
  created() {
    this.loadDevices();
    Fire.$on("AfterDelete", () => {
      this.loadDevices();
    });
  },
};
</script>

<style>
</style>
