<script setup>
import WelcomeItem from './WelcomeItem.vue'
import HelpIcon from './icons/HelpIcon.vue'
import UploadIcon from './icons/UploadIcon.vue'
import TrainingIcon from './icons/TrainingIcon.vue'
import FeedbackIcon from './icons/FeedbackIcon.vue'
import PostIcon from './icons/PostIcon.vue'
</script>

<template>
  <WelcomeItem>
    <template #icon>
      <HelpIcon />
    </template>
    <template #heading>Help</template>
    <!-- todo -->
  </WelcomeItem>

  <WelcomeItem>
    <template #icon>
      <UploadIcon />
    </template>
    <template #heading>Upload</template>
    <!-- todo -->
  </WelcomeItem>

  <WelcomeItem>
    <template #icon>
      <TrainingIcon />
    </template>
    <template #heading>Training</template>
    <!-- todo -->
  </WelcomeItem>

  <WelcomeItem>
    <template #icon>
      <FeedbackIcon />
    </template>
    <template #heading>Feedback</template>
    <!-- todo -->
  </WelcomeItem>

  <WelcomeItem>
    <template #icon>
      <PostIcon />
    </template>
    <template #heading>Posts</template>
    <!-- todo -->
  </WelcomeItem>
</template>
