<script setup>
import WelcomeItem from './WelcomeItem.vue'
import DocumentationIcon from './icons/IconDocumentation.vue'
import EcosystemIcon from './icons/IconEcosystem.vue'
import CommunityIcon from './icons/IconCommunity.vue'
import HeartIcon from './icons/IconHeart.vue'
</script>

<template>
  <WelcomeItem>
    <template #icon>
      <DocumentationIcon />
    </template>
    <template #heading>Documentation</template>
    Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque voluptatem porro qui laborum est fugit
    voluptatibus
    nulla cumque nemo, aperiam culpa, dolore officia sunt inventore velit at veritatis vero consectetur! Sint tenetur a
    ullam illum reprehenderit, explicabo veritatis facere eveniet fugit modi voluptatum porro ipsum earum qui maiores
    aliquam beatae!
  </WelcomeItem>

  <WelcomeItem>
    <template #icon>
      <EcosystemIcon />
    </template>
    <template #heading>Ecosystem</template>
    Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi doloremque cumque praesentium omnis voluptates
    placeat
    nemo sapiente sunt veritatis excepturi.
  </WelcomeItem>

  <WelcomeItem>
    <template #icon>
      <CommunityIcon />
    </template>
    <template #heading>Community</template>
    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ut iusto totam ullam illum aliquid dolore enim? Deserunt
    molestias, nisi nemo eos debitis saepe quia odio consequuntur, expedita adipisci nam possimus!
  </WelcomeItem>

  <WelcomeItem>
    <template #icon>
      <HeartIcon />
    </template>
    <template #heading>Framework</template>
    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quis ab dolor quo eaque molestias commodi ipsa
    perferendis.
    Et, consectetur iusto?
  </WelcomeItem>
</template>
