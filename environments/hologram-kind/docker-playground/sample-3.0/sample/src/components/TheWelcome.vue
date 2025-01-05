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
    Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam, obcaecati voluptates recusandae aspernatur
    provident alias nobis. Quibusdam excepturi distinctio labore nisi, nam maiores expedita natus iure nihil est
    provident
    tempora commodi inventore error, et impedit explicabo hic enim fuga voluptates?
  </WelcomeItem>

  <WelcomeItem>
    <template #icon>
      <EcosystemIcon />
    </template>
    <template #heading>Ecosystem</template>
    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Reiciendis, maiores voluptatibus nostrum quis aliquam
    quibusdam voluptas sequi esse minima sapiente, labore fugit aperiam iste harum laboriosam hic consectetur sit
    facere.
  </WelcomeItem>

  <WelcomeItem>
    <template #icon>
      <CommunityIcon />
    </template>
    <template #heading>Community</template>
    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sit, laudantium! Itaque veritatis consequatur repellat
    exercitationem dolores provident, totam magni, fugiat ad rem maxime doloribus aliquam. Eveniet corrupti ducimus,
    porro
    libero dicta error fugiat exercitationem aliquam quo praesentium iste aperiam nihil nulla. Explicabo nemo aliquid
    mollitia nesciunt adipisci, error eos ipsum.
  </WelcomeItem>

  <WelcomeItem>
    <template #icon>
      <HeartIcon />
    </template>
    <template #heading>Framework</template>
    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Accusamus, quibusdam.
  </WelcomeItem>
</template>
