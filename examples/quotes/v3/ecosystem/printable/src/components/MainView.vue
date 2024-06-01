<script setup>
import { ref } from 'vue'
import MainViewItem from './MainViewItem.vue'
import { articleStore } from '@/stores/articles'

const articles = ref()
const store = articleStore()

/** the consumer of the promise object */
const consumer = () => {
  store.promise.then(
    (result) => {
      articles.value = result.data
      console.log(articles.value)
    }
  )
  store.promise.catch(
    error => console.log(error)
  )
}

consumer()
</script>

<template>
  <div v-for="article in articles" :key="article.id">
    <div v-if="!article.deprecated">
      <MainViewItem>
        {{ article.title }}
      </MainViewItem>
    </div>
  </div>
</template>
