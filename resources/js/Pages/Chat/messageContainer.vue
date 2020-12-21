<template>
  <div class="h-96 w-full">
    <div class="h-full p-2 flex flex-col-reverse overflow-y-scroll">
      <div v-for="(message, idx) in messages" :key="idx">
        <message-item :message="message" />
      </div>
    </div>
  </div>
</template>

<script>
  import messageItem from "./messageItem.vue";
  export default {
    components: { messageItem },
    props: ["messages"]
  };
</script>

<style>
</style>