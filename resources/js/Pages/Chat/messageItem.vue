<template>
  <div>
    <span class="text-blue-700 font-bold"> {{ message.user.name }}: </span>
    {{ message.message }}
  </div>
</template>

<script>
  export default {
    props: ["message"]
  };
</script>

<style>
</style>