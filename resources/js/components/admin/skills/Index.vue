<template>
    <Base></Base>
    <main class="main">
        <div class="main__sideNav"></div>
        <div class="main__content">
            <section class="skills section" id="skills">
                <div class="skills_container">
                    <div class="titlebar">
                        <div class="titlebar_item">
                            <h1>Skills </h1>
                        </div>
                        <div class="titlebar_item">
                            <div class="btn" @click="this.openModal()">
                                New Skill
                            </div>
                        </div>
                    </div>

                    <div class="table">

                        <div class="table_filter">
                            <span class="table_filter-Btn ">
                                <i class="fas fa-ellipsis-h"></i>
                            </span>
                            <div>
                                <ul class="table_filter-list">
                                    <li>
                                        <p class="table_filter-link table_filter-link--active">
                                            All
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="table_search">
                            <div class="table_search-wrapper">
                                <select class="table_search-select" name="" id="">
                                    <option value="">Filter</option>
                                </select>
                            </div>
                            <div class="relative">
                                <i class="table_search-input--icon fas fa-search "></i>
                                <input class="table_search--input" type="text" placeholder="Search Service">
                            </div>
                        </div>

                        <div class="skill_table-heading">
                            <p>Name</p>
                            <p>Proficiency</p>
                            <p>Service</p>
                            <p>Actions</p>
                        </div>
                        <!-- item 1 -->
                        <div class="skill_table-items" v-for="item in skills" :key="item.id" v-if="this.skills.length > 0">
                            <p>{{item.name}}</p>
                            <div class="table_skills-bar">
                                <span class="table_skills-percentage" :style="{'width' : `${item.proficiency}%`}"></span>
                                <strong>{{item.proficiency}}%</strong>
                            </div>
                            <p v-if="item.service">{{item.service.name}}</p>
                            <div>
                                <button class="btn-icon success" @click="editModal(item)">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button class="btn-icon danger" @click="deleteSkill(item.id)">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>

                    </div>

                </div>
                <!-------------- SERVICES MODAL --------------->
                <div class="modal main__modal " :class="{ show : showModal}">
                    <div class="modal__content">
                        <span class="modal__close btn__close--modal" @click="this.closeModal()">×</span>
                        <h3 class="modal__title" v-show="this.editMode === false">Add Skill</h3>
                        <h3 class="modal__title" v-show="this.editMode === true">Edit Skill</h3>
                        <hr class="modal_line"><br>
                        <form @submit.prevent=" this.editMode ? this.updateSkill() : this.createSkill()">
                        <div>
                            <p>Name</p>
                            <input type="text" class="input" v-model="form.name"/>

                            <p>Proficiency</p>
                            <input type="text" class="input" v-model="form.proficiency"/>

                            <p>Service</p>
                            <select class="inputSelect" name=""  v-model="form.service_id">
                                <option disabled>Select service</option>
                                <option :value="service.id" v-for="service in services" :key="service.id">
                                    {{service.name}}
                                </option>
                            </select>
                        </div>
                        <br><hr class="modal_line">
                        <div class="model__footer">
                            <button class="btn mr-2 btn__close--modal" @click="closeModal()">
                                Cancel
                            </button>
                            <button class="btn btn-secondary btn__close--modal " v-show="this.editMode === false">Save</button>
                            <button class="btn btn-secondary btn__close--modal " v-show="this.editMode === true">Update</button>
                        </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </main>
</template>

<script>
    import Base from "../layouts/Base";
    export default {
        name: "Index",
        components : {
            Base
        },
        data : function () {
            return {
                skills : [],
                services : [],
                showModal : false ,
                hideModal : true ,
                form : {
                    'name' : '',
                    'proficiency' : '',
                    'service_id' : '',
                },
                editMode : false,
            }
        },
        mounted() {
            this.getSkills();
            this.getServices();
        },
        methods : {
          getSkills : function () {
              axios.get('/api/get_all_skills')
                  .then(response => {
                      this.skills = response.data.skills;
                  })
                  .catch(error => {

                  })
          },
          deleteSkill : function(id) {
              Swal.fire({
                  title : 'Are You Sure ?',
                  text : "You Can't Go Back !",
                  icon : 'warning',
                  showCancelButton : true,
                  confirmButtonColor : '#3085d6',
                  cancelButtonColor : '#d33',
                  confirmButtonText : 'Yes , Delete it !',
              })
                  .then((result) => {
                      if(result) {
                          axios.get('/api/delete_skill/'+id)
                              .then(() => {
                                  Swal.fire(
                                      'Delete',
                                      'Skill Deleted Successfully',
                                      'success'
                                  )
                                  this.getSkills();
                              })
                      }
                  });
          },
          getServices : function () {
            axios.get('/api/get_all_service')
                  .then(response => {
                       this.services = response.data.services ;
                  })
                  .catch(error => {

                  })
            },
          openModal : function () {
            this.showModal = !this.showModal;
            },
          closeModal : function () {
            this.showModal = !this.hideModal;
            this.form = {};
            this.editMode = false;
            },
            editModal : function (item) {
              this.editMode = true;
              this.showModal = !this.showModal;
              this.form = item;
            },
            updateSkill : function () {
              axios.post('/api/update_skill/'+this.form.id , this.form)
                  .then(response => {
                    toast.fire({
                        icon : "success",
                        title : "Skill Updated Successfully"
                    })
                      this.closeModal()
                      this.getSkills()
                  })
            },
            createSkill : function () {
                axios.post('/api/create_skill' , this.form)
                    .then(response => {
                        this.getSkills();
                        this.closeModal();
                        toast.fire({
                            icon : 'success',
                            title : 'Skill Added Successfully',
                        });
                    })
                    .catch(error => {

                    })
            }
        },
    }
</script>

<style scoped>

</style>
