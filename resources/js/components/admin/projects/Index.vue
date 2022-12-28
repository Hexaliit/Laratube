<template>
    <Base></Base>
    <main class="main">
        <div class="main__sideNav"></div>
        <div class="main__content">
            <section class="projects section" id="projects">
                <div class="skills_container">
                    <div class="titlebar">
                        <div class="titlebar_item">
                            <h1>Projects </h1>
                        </div>
                        <div class="titlebar_item">
                            <div class="btn btn__open--modal" @click="newProject">
                                New Project
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
                                <input class="table_search--input" type="text" placeholder="Search Project">
                            </div>
                        </div>

                        <div class="project_table-heading">
                            <p>Image</p>
                            <p>Title</p>
                            <p>Description</p>
                            <p>Link</p>
                            <p>Actions</p>
                        </div>
                        <!-- item 1 -->
                        <div class="project_table-items" v-if="this.projects.length > 0" v-for="item in projects" :key="item.id">
                            <p>
                                <img :src="this.ourImage(item.photo)" alt="" class="project_img-list">
                            </p>
                            <p>{{item.title}}</p>
                            <p>{{item.description}}</p>
                            <p>{{item.link}}</p>
                            <div>
                                <button class="btn-icon success" @click="onEdit(item.id)">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button class="btn-icon danger" @click="deleteProject(item.id)">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>

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
              projects : [],
          }
        },
        methods : {
            getProjects : function () {
                axios.get('/api/get_all_project')
                    .then(response => {
                        this.projects =  response.data.projects;
                    })
            },
            deleteProject : function (id) {
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
                            axios.get('/api/delete_project/'+id)
                                .then(() => {
                                    Swal.fire(
                                        'Delete',
                                        'Project Deleted Successfully',
                                        'success'
                                    )
                                    this.getProjects();
                                })
                        }
                    });
            },
            ourImage : function (img) {
                return "/img/upload/"+img;
            },
            newProject : function () {
                this.$router.push('/admin/projects/new');
            },
            onEdit : function (id) {
                this.$router.push('/admin/projects/edit/'+id);
            },
        },
        mounted() {
            this.getProjects();
        },
    }
</script>

<style scoped>

</style>
