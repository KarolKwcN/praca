<template>
  <div class="card-body">
    <div class="float-left">
      <a class="text-reset" href>Kategorie</a>
    </div>
    <br />
    <hr class="bg-info" />
    <div class="row">
      <div class="col-lg-12">
        <div class="float-right">
          <button type="button" @click.prevent="show" class="btn btn-success">Dodaj kategorię</button>
        </div>
        <table class="table table-bordered table-striped">
          <thead>
            <tr class="text-center bg-info text-light">
              <th>Id.</th>
              <th>Nazwa kategorii</th>
              <th>Edytuj</th>
              <th>Usuń</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="category in categories.data" :key="category.id" class="text-center">
              <td>{{ category.id }}</td>
              <td>
                <a href>{{ category.name }}</a>
              </td>
              <td>
                <button @click="editModal(category)" type="button" class="btn btn-info">
                  <i class="fas fa-edit"></i>
                </button>
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
        <div class="col-12 d-flex justify-content-center"></div>
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
                <h5 class="modal-title" v-show="!editmode" id="exampleModalLabel">Nowa kategoria</h5>
                <h5 class="modal-title" v-show="editmode" id="exampleModalLabel">Edytuj kategorię</h5>
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
              <form
                action="/api/admin/addCategory"
                method="POST"
                @submit.prevent="editmode ? updateCategory() : addCategory()"
              >
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
                  </div>
                </div>
                <div class="modal-footer">
                  <button
                    @click.prevent="hide"
                    type="button"
                    class="btn btn-secondary"
                    data-dismiss="modal"
                  >Zamknij</button>
                  <input v-show="editmode" type="submit" value="Zmień" class="btn btn-primary" />
                  <input v-show="!editmode" type="submit" value="Dodaj" class="btn btn-primary" />
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
  data() {
    return {
      editmode: false,
      categories: {},
      form: new Form({
        id: "",
        name: ""
      })
    };
  },
  methods: {
    updateCategory() {
      this.form.put("/api/admin/updateCategory/" + this.form.id).then(() => {
        Fire.$emit("AfterDelete");
        this.$modal.hide("modal-step");
      });
    },
    editModal(category) {
      this.editmode = true;
      this.$modal.show("modal-step");
      this.form.fill(category);
    },
    getResults(page = 1) {
      axios.get("/api/admin/showCategory?page=" + page).then(response => {
        this.categories = response.data;
      });
    },
    addCategory() {
      this.form.post("/api/admin/addCategory").then(() => {
        Fire.$emit("AfterDelete");
        this.$modal.hide("modal-step");
      });
    },
    deleteCategory(id) {
      Swal.fire({
        title: "Napewno chcesz usunąć kategorię ?",
        text: "Nie będzie można tego cofnąć.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Tak, usuń!"
      }).then(result => {
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
      this.editmode = false;
      this.form.reset();
      this.$modal.show("modal-step");
    },
    hide() {
      this.$modal.hide("modal-step");
    },
    loadCategories() {
      axios
        .get("/api/admin/showCategory")
        .then(response => (this.categories = response.data));
    }
  },
  created() {
    this.loadCategories();
    Fire.$on("AfterDelete", () => {
      this.loadCategories();
    });
  }
};
</script>

<style></style>
