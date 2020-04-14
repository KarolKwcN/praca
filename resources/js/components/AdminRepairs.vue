<template>
<div class="card-body">
    <div class="float-left">
        <a class="text-reset" href="">Kategorie</a>
    </div><br>
    <hr class="bg-info">
    <div class="row">
        <div class="col-lg-12">
            <div class="float-right">
                <button type="button" class="btn btn-success" @click="addCategory()">Dodaj kategorię</button>
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

                    <tr class="text-center">
                        <td> </td>
                        <td><a href=""></a></td>
                        <td><button type="button" class="btn btn-info"><i class="fas fa-edit"></i></button></td>
                        <td><button type="button" class="btn btn-danger"><i class="far fa-trash-alt"></i></button></td>
                    </tr>

                </tbody>

            </table>
            <div class="col-12 d-flex justify-content-center">

            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {

}
</script>

<style>

</style>
