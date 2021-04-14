<template>
  <div
    class="pb-6 px-6 relative break-words min-h-screen flex items-center w-full md:h-full md:shadow-lg md:rounded-lg"
    :class="template.css_class"
  >
    <div
      class="card flex flex-col w-full items-center p-4 rounded-lg bg-white	bg-opacity-10 shadow-2xl"
    >
      <h4 class="mb-4 font-semibold">
        {{pageProps.title_success}}
      </h4>
      <p class="text-center" style="white-space: pre-wrap;">
        {{pageProps.description_success}}
      </p>
      <a
        :href="`${pageProps.link_download}`"
        class="btn-color inline-block mx-auto mt-6 px-4 py-2 font-medium transition-colors duration-150  rounded-lg focus:outline-none"
        >{{pageProps.btn_success}}
      </a>
    </div>
  </div>
</template>

<script>
export default {
  props: ['pageProps', 'template'],
  data() {
    return {};
  },
  methods: {},
  mounted() {
    // убираем за собой
    localStorage.removeItem("check-first-screen");
    document.cookie = "url" + '=; Max-Age=-1'
  }
};
</script>

<style>
</style>
