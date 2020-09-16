<template>
  <div>
    <div class="row">
      <div class="col-lg-12">
        <div class="float-right">
          <button type="button" @click.prevent="show" class="btn btn-success">Dodaj markę</button>
        </div>
        <table class="table table-bordered table-striped">
          <thead>
            <tr class="text-center bg-info text-light">
              <th>Nazwa marki</th>
              <th>Opis</th>
              <th>Edytuj</th>
              <th>Usuń</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(brand, ind ) in brands.data" :key="ind" class="text-center">
              <td>
                <a :href="`/admin/naprawy/`+categoryName.slug+`/`+brand.slugi">{{ brand.name }}</a>
              </td>
              <td>{{brand.description}}</td>
              <td>
                <button type="button" @click="editBrand(ind)" class="btn btn-info">
                  <i class="fas fa-edit"></i>
                </button>
              </td>
              <td>
                <button @click="deleteBrand(brand.id)" type="button" class="btn btn-danger">
                  <i class="far fa-trash-alt"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="card-footer">
          <pagination :data="brands" @pagination-change-page="getResults"></pagination>
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
                <h5 class="modal-title" id="exampleModalLabel">Nowa marka</h5>
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
              <form enctype="multipart/form-data" method="POST" @submit.prevent="addBrand()">
                <div class="modal-body">
                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Nazwa marki:</label>
                    <input
                      type="text"
                      v-model="form.name"
                      name="name"
                      class="form-control"
                      id="recipient-name"
                    />
                    <!-- <span style="color:red" v-if="errors.name" class="error">{{errors.name[0]}}</span>-->
                  </div>
                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Opis marki:</label>
                    <textarea
                      v-model="form.description"
                      class="form-control"
                      id="recipient-description"
                    ></textarea>
                    <!--  <span style="color:red" v-if="errors.description" class="error">{{errors.description[0]}}</span>-->
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
                      <!-- <span style="color:red" v-if="errors.image" class="error">{{errors.image[0]}}</span>-->
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
        name="modal-edytuj-marke"
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
                <h5 class="modal-title" id="exampleModalLabel">Edytuj markę</h5>
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
                    <label for="recipient-name" class="col-form-label">Nazwa marki:</label>
                    <input
                      type="text"
                      v-model="edit_brand.name"
                      name="name"
                      class="form-control"
                      id="recipient-name"
                    />
                    <!-- <span style="color:red" v-if="errors.name" class="error">{{errors.name[0]}}</span> -->
                  </div>
                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Opis marki:</label>
                    <textarea
                      v-model="edit_brand.description"
                      class="form-control"
                      id="recipient-description"
                    ></textarea>
                    <!-- <span style="color:red" v-if="errors.description" class="error">{{errors.description[0]}}</span> -->
                  </div>
                  <div class="form-group">
                    <div v-if="!isHidden" class="input-group">
                      <img
                        width="150px"
                        class="img-fluid d-block new2 mx-2"
                        :src="edit_brand.image"
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
                  <input type="submit" @click="updateBrand" value="Zmień" class="btn btn-primary" />
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
  props: ["category"],
  data() {
    return {
      isHidden: false,
      brands: {},
      edit_brand: [],
      categoryName: {},
      picsss: 1,
      edit_image: null,
      form: new Form({
        id: "",
        name: "",
        description: "",
        image: "",
      }),
      errors: [],
    };
  },
  methods: {
    onImageChange(e) {
      this.form.image = e.target.files[0];
    },
    onImageChangee(e) {
      this.edit_image = e.target.files[0];
      this.picsss = 1;
    },
    editBrand(ind) {
      this.isHidden = false;
      this.$modal.show("modal-edytuj-marke");
      this.edit_brand = this.brands.data[ind];
    },
    removeimage: function () {
      this.edit_brand.image = "";
      this.isHidden = true;
      this.picsss = "";
    },
    updateBrand(e) {
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

      if (this.edit_image) {
        formData.append("image", this.edit_image);
      }

      formData.append("name", this.edit_brand.name);
      formData.append("description", this.edit_brand.description);
      formData.append("picsss", this.picsss);

      axios
        .post("/api/admin/updateBrand/" + this.edit_brand.id, formData, config)
        .then(function (response) {
          currentObj.success = response.data.success;
          Fire.$emit("AfterDelete");
          self.hideedit("modal-edytuj-marke");
          //window.location.reload();
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          }
        });
    },
    addBrand() {
      this.errors = [];
      let formData = new FormData();
      formData.append("image", this.form.image);
      formData.append("name", this.form.name);
      formData.append("description", this.form.description);
      axios
        .post("/api/admin/addBrand/" + this.category, formData)
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
    deleteBrand(id) {
      Swal.fire({
        title: "Na pewno chcesz usunąć markę ?",
        text: "Nie będzie można tego cofnąć.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Tak, usuń!",
      }).then((result) => {
        if (result.value) {
          axios
            .delete("/api/admin/deleteBrand/" + id)
            .then(() => {
              Swal.fire("Marka została usunięta");
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
    hide() {
      this.errors = [];
      this.$modal.hide("modal-step");
    },
    editClosed(event) {
      this.errors = [];
      Fire.$emit("AfterDelete");
      this.picsss = 1;
    },
    Closed(event) {
      this.errors = [];
      this.image = "";
      this.name = "";
      this.description = "";
    },

    loadBrands() {
      axios
        .get("/api/admin/showBrands/" + this.category)
        .then((response) => (this.brands = response.data));
    },
    hideedit() {
      this.errors = [];
      this.$modal.hide("modal-edytuj-marke");
      Fire.$emit("AfterDelete");
      this.picsss = 1;
    },
    loadcategoryName() {
      axios
        .get("/api/admin/categoryName/" + this.category)
        .then((response) => (this.categoryName = response.data));
    },
    getResults(page = 1) {
      axios
        .get("/api/admin/showBrands/" + this.category + "?page=" + page)
        .then((response) => {
          this.brands = response.data;
        });
    },
  },
  created() {
    this.loadBrands();
    this.loadcategoryName();
    Fire.$on("AfterDelete", () => {
      this.loadBrands();
      this.loadcategoryName();
    });
  },
};
</script>

<style>
</style>
