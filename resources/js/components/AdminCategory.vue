<template>
  <div>
    <div class="row">
      <div class="col-lg-12">
        <div class="float-right">
          <button type="button" @click.prevent="show" class="btn btn-success">Dodaj kategorię</button>
        </div>
        <table class="table table-bordered table-striped">
          <thead>
            <tr class="text-center bg-info text-light">
              <th>Nazwa kategorii</th>
              <th>Edytuj</th>
              <th>Usuń</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(category, ind) in categories.data" :key="ind" class="text-center">
              <td>
                <a :href="`/admin/naprawy/`+category.slug">{{ category.name }}</a>
              </td>
              <td>
                <button type="button" @click="editCategory(ind)" class="btn btn-primary">Edytuj</button>
              </td>
              <td>
                <button @click="deleteCategory(category.id)" type="button" class="btn btn-danger">
                  <i class="far fa-trash-alt"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="card-footer">
          <pagination :data="categories" @pagination-change-page="getResults"></pagination>
        </div>
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
                <h5 class="modal-title" id="exampleModalLabel">Nowa kategoria</h5>
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
              <form enctype="multipart/form-data" method="POST" @submit.prevent="addCategory()">
                <div class="modal-body">
                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Nazwa kategorii:</label>
                    <input
                      type="text"
                      v-model="form.name"
                      name="name"
                      class="form-control"
                      id="recipient-name"
                    />
                    <!--<span style="color:red" v-if="errors.name" class="error">{{errors.name[0]}}</span>-->
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
                      <!--<span style="color:red" v-if="errors.image" class="error">{{errors.image[0]}}</span>-->
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
      <modal
        name="modal-edytuj-kategorie"
        height="auto"
        classes="demo-modal-class"
        @closed="editClosed"
      >
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
                <h5 class="modal-title" id="exampleModalLabel">Edytuj kategorię</h5>
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
              <div class="text-left" v-for="error in errors" :key="error.id">
                <ul v-for="err in error" :key="err.id">
                  <li class="text-danger">{{ err }}</li>
                </ul>
              </div>
              <form>
                <div class="modal-body">
                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Nazwa kategorii:</label>
                    <input
                      type="text"
                      v-model="edit_category.name"
                      name="name"
                      class="form-control"
                      id="recipient-name"
                    />
                    <!--<span style="color:red" v-if="errors.name" class="error">{{errors.name[0]}}</span>-->
                  </div>
                  <div class="form-group">
                    <div v-if="!isHidden" class="input-group">
                      <img
                        width="150px"
                        class="img-fluid d-block new2 mx-2"
                        :src="edit_category.image"
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
                          name="image"
                          class="input-file"
                          type="file"
                        />
                        <!-- <span style="color:red" v-if="errors.image" class="error">{{errors.image[0]}}</span> -->
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
                  <input
                    type="submit"
                    @click="updateCategory"
                    value="Zmień"
                    class="btn btn-primary"
                  />
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
  data() {
    return {
      isHidden: false,
      edit_category: [],
      categories: {},
      picsss: 1,
      edit_image: null,
      form: new Form({
        id: "",
        name: "",
        image: "",
      }),
      errors: [],
    };
  },
  methods: {
    updateCategory(e) {
      this.errors = [];
      e.preventDefault();
      let currentObj = this;
      var self = this;

      let formData = new FormData();
      if (this.edit_image) {
        formData.append("image", this.edit_image);
      }

      formData.append("name", this.edit_category.name);
      formData.append("picsss", this.picsss);

      axios
        .post("/api/admin/updateCategory/" + this.edit_category.id, formData)
        .then(function (response) {
          currentObj.success = response.data.success;
          Fire.$emit("AfterDelete");
          self.hideedit("modal-edytuj-kategorie");
          //window.location.reload();
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          }
        });
    },
    editCategory(ind) {
      this.isHidden = false;
      this.$modal.show("modal-edytuj-kategorie");
      this.edit_category = this.categories.data[ind];
    },
    removeimage: function () {
      this.edit_category.image = "";
      this.isHidden = true;
      this.picsss = "";
    },
    getResults(page = 1) {
      axios.get("/api/admin/showCategory?page=" + page).then((response) => {
        this.categories = response.data;
      });
    },
    onImageChange(e) {
      this.form.image = e.target.files[0];
    },
    onImageChangee(e) {
      this.edit_image = e.target.files[0];
      this.picsss = 1;
    },
    addCategory() {
      this.errors = [];
      let formData = new FormData();
      formData.append("image", this.form.image);
      formData.append("name", this.form.name);

      axios
        .post("/api/admin/addCategory", formData)
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
    Closed(event) {
      this.errors = [];
      this.image = "";
      this.name = "";
    },
    editClosed(event) {
      this.errors = [];
      Fire.$emit("AfterDelete");
      this.picsss = 1;
    },
    deleteCategory(id) {
      Swal.fire({
        title: "Na pewno chcesz usunąć kategorię ?",
        text: "Nie będzie można tego cofnąć.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Tak, usuń!",
      }).then((result) => {
        if (result.value) {
          axios
            .delete("/api/admin/deleteCategory/" + id)
            .then(() => {
              Swal.fire("Kategoria została usunięta");
              Fire.$emit("AfterDelete");
            })
            .catch(() => {
              Swal("Błąd!", "Coś poszło nie tak.", "Uwaga");
            });
        }
      });
    },
    show() {
      this.form.reset();
      this.$modal.show("modal-step");
    },
    hideedit() {
      this.errors = [];
      this.$modal.hide("modal-edytuj-kategorie");
      Fire.$emit("AfterDelete");
      this.picsss = 1;
    },
    hide() {
      this.errors = [];
      this.$modal.hide("modal-step");
    },
    loadCategories() {
      axios
        .get("/api/admin/showCategory")
        .then((response) => (this.categories = response.data));
    },
  },
  created() {
    this.loadCategories();
    Fire.$on("AfterDelete", () => {
      this.loadCategories();
    });
  },
};
</script>

<style></style>
