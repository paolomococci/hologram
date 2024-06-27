<script setup>
import NavItem from './NavItem.vue'
import HelpIcon from './icons/HelpIcon.vue'
import UploadIcon from './icons/UploadIcon.vue'
import EvaluateIcon from './icons/EvaluateIcon.vue'
import FeedbackIcon from './icons/FeedbackIcon.vue'
import PostIcon from './icons/PostIcon.vue'
import { RouterLink } from 'vue-router'
</script>

<template>
  <NavItem>
    <template #icon>
      <RouterLink to="/">
        <HelpIcon />
      </RouterLink>
    </template>
    <template #label>&#160;</template>
  </NavItem>

  <NavItem>
    <template #icon>
      <RouterLink to="/upload">
        <UploadIcon />
      </RouterLink>
    </template>
    <template #label>&#160;</template>
  </NavItem>

  <NavItem>
    <template #icon>
      <RouterLink to="/evaluate">
        <EvaluateIcon />
      </RouterLink>
    </template>
    <template #label>&#160;</template>
  </NavItem>

  <NavItem>
    <template #icon>
      <RouterLink to="/feedback">
        <FeedbackIcon />
      </RouterLink>
    </template>
    <template #label>&#160;</template>
  </NavItem>

  <NavItem>
    <template #icon>
      <RouterLink to="/post">
        <PostIcon />
      </RouterLink>
    </template>
    <template #label>&#160;</template>
  </NavItem>
</template>
