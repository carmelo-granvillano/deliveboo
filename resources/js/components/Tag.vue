<template>
  <section :class="{'d-none': loading}">
    <div class="py-2">
      <div class="row">
        <h2 class="title">Scopri le nostre categorie</h2>
        <ul class="list-unstyled d-flex flex-wrap mb-4">
          <li class="mt-2 mb-3 text-center pointer" v-for="(tag, index) in tags" :key="index">
            <!-- <router-link class="nav-link rest-tag fw-bold" :to="{name: 'category', params:{ slug: index }}">{{ tag }}</router-link> -->
            <span @click="emit(index)" class="nav-link rest-tag fw-bold" :class="{'bounce': tagsActive.indexOf(index) < 0}">{{ tag }}</span>
          </li>
        </ul>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "Tag",
  props: {
    tagsActive: Array
  },
  data(){
    return {
      url: '/api/category/?tags=show',
      tags: {},
      loading: true,
    }
  },
  mounted(){
    this.getTags();

  },
  methods: {
    async getTags(){
      this.loading = true;
      let response = await axios(this.url);
      this.tags = response.data.results;
      this.loading = false;
    },
    emit(slug){
      this.$emit('slugEmit', slug);
    }
  }
}
</script>

<style lang="scss" scoped>
@import 'resources/sass/_variables.scss';

  section{
    background-color: rgb(255, 214, 112);

    .title{
      color: $blue;
      font-weight: 500;
    }

    li{
      width: 120px;
      font-size: 16px;
      transition: 0.5s;
      margin: 0 10px;
      cursor: pointer;

      &:hover{
         transform: translateY(-5px);
      }
      
    }

    .rest-tag{
      background-color: $light-blue;
      margin: 0;
      border-radius: 15px;
      color: white;
      transition: 0.5s;

      &:hover{
        background-color: #4e87aa;
      }
    }
    .bounce{
      background-color: $blue;
      transform: translateY(20px);
    }

  }

</style>