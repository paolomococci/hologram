<script setup>
import WelcomeItem from './WelcomeItem.vue'
import DocumentationIcon from './icons/DocumentationIcon.vue'
import ToolingIcon from './icons/ToolingIcon.vue'
import EcosystemIcon from './icons/EcosystemIcon.vue'
import CommunityIcon from './icons/CommunityIcon.vue'
import DesiredIcon from './icons/DesiredIcon.vue'
import { CHARADE, ESTIMATE, FLARES, JOURNEY, RECOMMENDATION } from '../../env'
</script>

<template>
  <WelcomeItem>
    <template #icon>
      <DocumentationIcon />
    </template>
    <template #heading>Documentation</template>

    Likelihood <a href="#" target="_blank" rel="noopener">documentation</a> and basic information.
  </WelcomeItem>

  <WelcomeItem>
    <template #icon>
      <ToolingIcon />
    </template>
    <template #heading>Tooling</template>

    This project is developed thanks to the Vue.js framework, hosted on a web server Apache locally with the ability to
    access programming languages like PHP and Python, plus JavaScript of course.
  </WelcomeItem>

  <WelcomeItem>
    <template #icon>
      <EcosystemIcon />
    </template>
    <template #heading>Ecosystem</template>

    Below is a list of web applications that belong to this ecosystem:
    <ul>
      <li><a :href="FLARES" target="_blank" rel="noopener">flares</a></li>
      <li><a :href="JOURNEY" target="_blank" rel="noopener">journey</a></li>
      <li><a :href="ESTIMATE" target="_blank" rel="noopener">estimate</a></li>
      <li><a :href="CHARADE" target="_blank" rel="noopener">charade</a></li>
      <li><a :href="RECOMMENDATION" target="_blank" rel="noopener">recommendation</a></li>
    </ul>
  </WelcomeItem>

  <WelcomeItem>
    <template #icon>
      <CommunityIcon />
    </template>
    <template #heading>Community</template>

    If you would like to leave comments:
    <br>
    <a href="#" target="_blank" rel="noopener">I would say&#8230;</a>
  </WelcomeItem>

  <WelcomeItem>
    <template #icon>
      <DesiredIcon />
    </template>
    <template #heading>Desired</template>

    If you want something to be improved:
    <br>
    <a href="#" target="_blank" rel="noopener">It would be nice if&#8230;</a>
  </WelcomeItem>
</template>
