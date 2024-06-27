<script setup>
import WelcomeItem from './WelcomeItem.vue'
import HelpIcon from './icons/HelpIcon.vue'
import AttachIcon from './icons/AttachIcon.vue'
import EvaluateIcon from './icons/EvaluateIcon.vue'
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
      <AttachIcon />
    </template>
    <template #heading>Attach</template>
    <!-- todo -->
  </WelcomeItem>

  <WelcomeItem>
    <template #icon>
      <EvaluateIcon />
    </template>
    <template #heading>Evaluate</template>
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
