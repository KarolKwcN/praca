<template>
  <div>
    <button type="button" @click.prevent="show" class="btn btn-primary">Edytuj</button>

    <modal name="modal-edytuj-kategorie" height="auto" classes="demo-modal-class">
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
              <div class="modal-body">
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Nazwa kategorii:</label>
                  <input type="text" name="name" class="form-control" id="recipient-name" />
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label" for="filebutton">Wybierz zdjęcie:</label>
                  <div class="col-md-4">
                    <input id="upload-file" name="image" class="input-file" type="file" />
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
                <input type="submit" value="Zmień" class="btn btn-primary" />
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
  props: ["category_id"],
  data() {
    return {
      category: [],
      name: "",
      image: ""
    };
  },
  methods: {
    loadCategory() {
      axios
        .get("/api/admin/loadOneCategory/" + this.category_id)
        .then(response => (this.category = response.data));
    },
    show() {
      this.$modal.show("modal-edytuj-kategorie");
    },
    hide() {
      this.$modal.hide("modal-edytuj-kategorie");
    }
  },
  created() {
    this.loadCategory();
  }
};
</script>

<style>
</style>
