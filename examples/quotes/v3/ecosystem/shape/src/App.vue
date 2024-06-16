<script setup>
import { ref } from 'vue'
import { RouterLink, RouterView } from 'vue-router'

const hamburger = ref(false)
</script>

<template>
  <header>
    <div class="flex items-center space-x-2">
      <nav class="overflow-hidden w-screen bg-gradient-to-tr from-indigo-700 to-indigo-400 h-fit">
        <div class="py-4 lg:px-8 px-4 max-w-[960px] h-16 m-auto text-indigo-200 flex items-center justify-between">
          <h1 class="text-xl font-semibold tracking-wide uppercase cursor-pointer lg:text-2xl">shape</h1>
        </div>
        <div class="flex flex-1 gap-8 justify-end -mt-11 mr-4 mb-4 text-lg tracking-wide uppercase cursor-pointer">

          <!-- normal navbar -->
          <div class="flex flex-1 gap-8 justify-end max-sm:hidden">
            <div class="group hover:scale-125">
              <span class="text-indigo-200 hover:text-purple-400 group-hover:animate-pulse">
                <RouterLink to="/">Home</RouterLink>
              </span>
              <div
                class="w-0 h-[0.5px] bg-purple-400 duration-300 ease-linear group-hover:w-full group-hover:animate-pulse">
              </div>
            </div>
            <div class="group hover:scale-125">
              <span class="text-indigo-200 hover:text-purple-400 group-hover:animate-pulse">
                <RouterLink to="/more">More</RouterLink>
              </span>
              <div
                class="w-0 h-[0.5px] bg-purple-400 duration-300 ease-linear group-hover:w-full group-hover:animate-pulse">
              </div>
            </div>
            <div class="group hover:scale-125">
              <span class="text-indigo-200 hover:text-purple-400 group-hover:animate-pulse">
                <RouterLink to="/upload">Upload</RouterLink>
              </span>
              <div
                class="w-0 h-[0.5px] bg-purple-400 duration-300 ease-linear group-hover:w-full group-hover:animate-pulse">
              </div>
            </div>
            <div class="group hover:scale-125">
              <span class="text-indigo-200 hover:text-purple-400 group-hover:animate-pulse">
                <RouterLink to="/update">Update</RouterLink>
              </span>
              <div
                class="w-0 h-[0.5px] bg-purple-400 duration-300 ease-linear group-hover:w-full group-hover:animate-pulse">
              </div>
            </div>
            <div class="group hover:scale-125">
              <span class="text-indigo-200 hover:text-purple-400 group-hover:animate-pulse">
                <RouterLink to="/response">Response</RouterLink>
              </span>
              <div
                class="w-0 h-[0.5px] bg-purple-400 duration-300 ease-linear group-hover:w-full group-hover:animate-pulse">
              </div>
            </div>
          </div>

          <!-- hamburger navbar -->
          <div class="flex items-center -me-2 sm:hidden">
            <button
              class="inline-flex justify-center items-center p-2 text-indigo-200 rounded-full transition duration-75 ease-in-out hover:text-indigo-500 hover:bg-indigo-100 focus:outline-none focus:bg-indigo-100 focus:text-indigo-500"
              @click="hamburger = !hamburger">
              <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{ 'hidden': hamburger, 'inline-flex': !hamburger }" stroke-linecap="round"
                  stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{ 'hidden': !hamburger, 'inline-flex': hamburger }" stroke-linecap="round"
                  stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
        <div :class="{ 'block': hamburger, 'hidden': !hamburger }" class="sm:hidden">
          <div class="pt-2 pb-3 space-y-1 uppercase">
            <div class="ml-4">
              <span class="text-indigo-200 hover:text-purple-400 hover:animate-pulse">
                <RouterLink to="/">Home</RouterLink>
              </span>
            </div>
            <div class="ml-4">
              <span class="text-indigo-200 hover:text-purple-400 hover:animate-pulse">
                <RouterLink to="/more">More</RouterLink>
              </span>
            </div>
            <div class="ml-4">
              <span class="text-indigo-200 hover:text-purple-400 hover:animate-pulse">
                <RouterLink to="/upload">Upload</RouterLink>
              </span>
            </div>
            <div class="ml-4">
              <span class="text-indigo-200 hover:text-purple-400 hover:animate-pulse">
                <RouterLink to="/update">Update</RouterLink>
              </span>
            </div>
            <div class="ml-4">
              <span class="text-indigo-200 hover:text-purple-400 hover:animate-pulse">
                <RouterLink to="/response">Response</RouterLink>
              </span>
            </div>
          </div>
        </div>
      </nav>
    </div>
  </header>

  <RouterView />
</template>

<style scoped></style>
