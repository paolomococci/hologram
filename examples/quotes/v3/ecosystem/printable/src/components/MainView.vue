<script setup>
import { ref, watch } from 'vue'
import MainViewItem from './MainViewItem.vue'
import { articleStore } from '@/stores/articles'
import { filterStore } from '@/stores/filter'

const articles = ref()
const filteredArticles = ref([])
const store = articleStore()
const filter = filterStore()

/** the consumer of the promise object */
const consumer = () => {
  store.promise.then(
    (result) => {
      articles.value = result.data
    }
  )
  store.promise.catch(
    error => console.log(error)
  )
}

consumer()

/** use a watcher in getter mode */
watch(() => filter.filterText, (text) => {
  filterArticles(text)
  if (text.length < 1) {
    filteredArticles.value = []
  }
})

/** makes sure to list only the articles that have a certain text in the title, subject or summary */
function filterArticles(text) {
  filteredArticles.value = []
  articles.value.forEach(article => {
    if (article.title.includes(text) || article.subject.includes(text) || article.summary.includes(text)) {
      filteredArticles.value.push(article)
    }
  })
}
</script>

<template>
  <div v-for="article in filteredArticles" :key="article.id">
    <div v-if="!article.deprecated">
      <MainViewItem>
        {{ article.title }}
      </MainViewItem>
    </div>
  </div>
</template>
