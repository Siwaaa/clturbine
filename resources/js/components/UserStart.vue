<template>
  <div
    class="pb-6 sm:w-96 w-full relative break-words min-h-screen md:h-full md:shadow-lg md:rounded-lg"
    :class="template.css_class"
  >
    <div class="w-full overflow-hidden size z-20">
      <img :src="srcImg" class="w-full" />
    </div>
    <header class="mt-4 px-6">
      <h1 class="text-3xl font-semibold">{{ pageProps.title_ad }}</h1>
    </header>
    <main class="mt-4 px-6 flex flex-col">
      <div class="decription">
        <p style="white-space: pre-wrap">{{ pageProps.description_ad }}</p>
      </div>
      <Timer
        v-if="pageProps.timer"
        :timer_text="pageProps.timer_text"
        :timer_sec="pageProps.timer_sec"
      ></Timer>
      <a
        :href="`/${pageProps.url}/inst`"
        class="btn-color btn-animate w-full inline-block text-center my-6 px-4 py-2 font-medium transition-all duration-150 transform active:scale-105 rounded-lg focus:outline-none overflow-hidden relative"
        >{{ pageProps.btn_ad }}</a
      >

      <label class="inline-block absolute bottom-2 inset-x-0 text-sm text-center"
        >Сделано в
        <a href="#" target="_blank" class=""
          >ClientTurbine</a
        ></label
      >
    </main>
  </div>
</template>

<script>
import Timer from "./Elements/Timer.vue";
export default {
  components: { Timer },
  props: ["pageProps", "template"],
  data() {
    return {
      ds: false,
      className: "bg-purple-600",
      srcImg: null,
        // urlAPI: "http://127.0.0.1:8001",
      urlAPI: "https://api.client-turbine.ru",
    };
  },
  computed: {},
  created() {
    const options = {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    };
    fetch(`${this.urlAPI}/api/${this.pageProps.url}/img`, options)
      .then((response) => response.json())
      .then((res) => {
        if (res.success) {
          this.srcImg = res.img;
        }
      });
  },
};
</script>
