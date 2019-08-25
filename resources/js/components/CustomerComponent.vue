<template>
    <div id="customer">
        <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Customers Dashboard</h3>
                  <div class="card-tools"  style="position:absulate; right:1rem; top: .5rem">
                    <button type="button" class="btn btn-primary pull-right"><i class="fa fa-plus"></i></button>
                  </div>
                </div>

                <div class="card-body">
                  <div class="mb-3">
                    <div class="row">
                      <div class="col-md-2 mr-0">
                        <strong>Search By :</strong>
                      </div>
                      <div class="col-md-3 ml-0">
                        <select class="form-control" id="fields" v-model="queryField">
                          <option value="name">Name</option>
                          <option value="email">Email</option>
                          <option value="phone">Phone</option>
                          <option value="address">Address</option>
                          <option value="total">Total</option>
                        </select>
                      </div>
                      <div class="col-md-7">
                        <input type="text" v-model="query" class="form-control" placeholder="Search">
                      </div>
                    </div>
                  </div>
                    <div class="table-responsive table-bordered">
                      <table class="table">
                        <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Name</th>
                          <th scope="col">Email</th>
                          <th scope="col">Phone</th>
                          <th scope="col">Total</th>
                          <th scope="col" class="text-center">Action</th>
                        </tr>
                      </thead>
                        <tbody>
                          <tr
                            v-show = "customers.length" v-for="(customer, index) in customers"
                            :key="customer.id"
                          >
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ customer.name}}</td>
                            <td>{{ customer.email }}</td>
                            <td>{{ customer.phone }}</td>
                            <td>{{ customer.total }}</td>
                            <td class="text-center">
                              <button type="button" @click="show(customer)" class="btn btn-info btn-sm">
                                <i class="fa fa-eye"></i>
                              </button>
                              <button type="button" @click="edit(customer)" class="btn btn-primary btn-sm">
                                <i class="fa fa-edit"></i>
                              </button>
                              <button
                                type="button"
                                @click="destroy(customer)"
                                class="btn btn-danger btn-sm"
                              >
                                <i class="fa fa-trash"></i>
                              </button>
                            </td>
                          </tr>
                          <tr v-show="!customers.length">
                            <td colspan="6">
                              <div class="alert alert-danger" role="alert">Sorry :( No data found.</div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <pagination
                        v-if="pagination.last_page > 1"
                        :pagination="pagination"
                        :offset="5"
                        @paginate="query === '' ? getData() : searchData()"
                        >
                
                     </pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <vue-progress-bar></vue-progress-bar>
  </div>
</template>

<script>
    export default {
      data(){
        return {
          query: '',
          queryField: 'name',
          customers: [],
          pagination: {
            current_page: 1,
          }
        }
      },
      watch: {
        query: function(newQ, old) {
          if (newQ === "") {
            this.getData();
          } else {
            this.searchData();
          }
        }
      },
        mounted() {
            //console.log('Component mounted.')
            this.getData()
            
        },
        methods: {
          getData(){
            this.$Progress.start()
            axios.get(`api/customers?page=`+this.pagination.current_page)
                 .then(response =>{
                  this.customers = response.data.data
                  this.pagination = response.data.meta
                  this.$Progress.finish()
                 })
                 .catch(e =>{
                  console.log(e)
                  this.$Progress.fail()
                 })
          },
          searchData(){
            this.$Progress.start();
              axios
                .get(
                  "/api/search/customers/" +
                    this.queryField +
                    "/" +
                    this.query +
                    "?page=" +
                    this.pagination.current_page
                )
                .then(response => {
                  this.customers = response.data.data;
                  this.pagination = response.data.meta;
                  this.$Progress.finish();
                })
                .catch(e => {
                  console.log(e);
                  this.$Progress.fail();
                });
          }
        }
    }
</script>
<style>
  #addbut{
    position: absulate;
    right:1rem;
    top:.5rem
  }
</style>
