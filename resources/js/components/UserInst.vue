<template>
  <div
    class="pb-6 pt-12 px-6 w-full relative min-h-screen md:h-full md:shadow-lg md:rounded-lg"
    :class="template.css_class"
  >
    <vue-progress-bar></vue-progress-bar>
    <div class="inst w-full flex items-center flex-col">
      <img v-if="instinfo" :src="instinfo.profile_url" alt="avatar" class="h-20 w-20 overflow-hidden" style="border-radius: 50%"/>
      <img v-else src="/img/ava.svg" alt="avatar">
      <h4 class="font-bold mt-2">{{instinfo.full_name}}</h4>
      <span class="flex items-center">
        <svg class="inline mr-2" viewBox="0 0 48 48" width="24px" height="24px">
          <radialGradient
            id="yOrnnhliCrdS2gy~4tD8ma"
            cx="19.38"
            cy="42.035"
            r="44.899"
            gradientUnits="userSpaceOnUse"
          >
            <stop offset="0" stop-color="#fd5" />
            <stop offset=".328" stop-color="#ff543f" />
            <stop offset=".348" stop-color="#fc5245" />
            <stop offset=".504" stop-color="#e64771" />
            <stop offset=".643" stop-color="#d53e91" />
            <stop offset=".761" stop-color="#cc39a4" />
            <stop offset=".841" stop-color="#c837ab" />
          </radialGradient>
          <path
            fill="url(#yOrnnhliCrdS2gy~4tD8ma)"
            d="M34.017,41.99l-20,0.019c-4.4,0.004-8.003-3.592-8.008-7.992l-0.019-20	c-0.004-4.4,3.592-8.003,7.992-8.008l20-0.019c4.4-0.004,8.003,3.592,8.008,7.992l0.019,20	C42.014,38.383,38.417,41.986,34.017,41.99z"
          />
          <radialGradient
            id="yOrnnhliCrdS2gy~4tD8mb"
            cx="11.786"
            cy="5.54"
            r="29.813"
            gradientTransform="matrix(1 0 0 .6663 0 1.849)"
            gradientUnits="userSpaceOnUse"
          >
            <stop offset="0" stop-color="#4168c9" />
            <stop offset=".999" stop-color="#4168c9" stop-opacity="0" />
          </radialGradient>
          <path
            fill="url(#yOrnnhliCrdS2gy~4tD8mb)"
            d="M34.017,41.99l-20,0.019c-4.4,0.004-8.003-3.592-8.008-7.992l-0.019-20	c-0.004-4.4,3.592-8.003,7.992-8.008l20-0.019c4.4-0.004,8.003,3.592,8.008,7.992l0.019,20	C42.014,38.383,38.417,41.986,34.017,41.99z"
          />
          <path
            fill="#fff"
            d="M24,31c-3.859,0-7-3.14-7-7s3.141-7,7-7s7,3.14,7,7S27.859,31,24,31z M24,19c-2.757,0-5,2.243-5,5	s2.243,5,5,5s5-2.243,5-5S26.757,19,24,19z"
          />
          <circle cx="31.5" cy="16.5" r="1.5" fill="#fff" />
          <path
            fill="#fff"
            d="M30,37H18c-3.859,0-7-3.14-7-7V18c0-3.86,3.141-7,7-7h12c3.859,0,7,3.14,7,7v12	C37,33.86,33.859,37,30,37z M18,13c-2.757,0-5,2.243-5,5v12c0,2.757,2.243,5,5,5h12c2.757,0,5-2.243,5-5V18c0-2.757-2.243-5-5-5H18z"
          /></svg
        >{{ pageProps.instagram }}
      </span>
    </div>
    <main class="my-mt">
      <!-- Первый вариант -->
      <form
        v-if="!checkFirstScreen"
        class="input-container w-full md:max-w-xs md:m-auto mt-4 text-center"
      >
        <h2 class="font-bold text-xl leading-5">
          Подпишись на мой инстаграм и ссылка для скачивания материалов станет
          доступна
        </h2>
        <a
          :href="`https://www.instagram.com/${pageProps.instagram}/`"
          target="_black"
          @click.prevent="warning"
          class="btn-color inline-block w-full mt-6 px-4 py-2 font-medium transition-colors duration-150  rounded-lg focus:outline-none"
        >
          Подписаться
        </a>
        <button
          @click.prevent="setCheck"
          type="button"
          class="inline w-full mt-2 underline"
        >
          Я подписался
        </button>
        <!-- Modal -->
        <div
          v-show="isModalOpen"
          class="fixed inset-0 z-30 flex bg-black bg-opacity-50 items-center sm:justify-center"
        >
          <div
            class="w-full px-6 py-4 z-50 overflow-hidden bg-white rounded-lg sm:rounded-lg sm:m-4 sm:max-w-xl"
            role="dialog"
            id="modal"
          >
            <!-- Modal body -->
            <div class="mt-4 mb-6">
              <!-- Modal title -->
              <p
                class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300"
              >
                Идет переадресация...
              </p>
              <!-- Modal description -->
              <p class="text-sm text-gray-700 dark:text-gray-400">
                После подписки вернись на эту страницу для подтверждения, нажав
                кнопку "назад" в браузере
              </p>
            </div>
          </div>
        </div>
      </form>
      <!-- Второй вариант -->
      <form
        v-else
        @submit.prevent="searchAk"
        class="input-container w-full md:max-w-xs md:m-auto mt-4 text-center"
      >
        <input type="hidden" name="_token" :value="csrf">
        <h2 class="font-bold text-xl leading-5">
          Введите ваш логин инстаграма для проверки подписки:
        </h2>
        <input
          v-model="inst"
          type="text"
          maxlength="24"
          required
          class="w-full form-input mt-8 text-black focus:outline-none"
        />
        <button
          type="submit"
          class="btn-color inline-block w-full mt-2 px-4 py-2 font-medium transition-colors duration-150  rounded-lg focus:outline-none"
        >
          Проверить
        </button>
        <a
          :href="`https://www.instagram.com/${pageProps.instagram}/`"
          target="_black"
          class="inline-block w-full mt-2 underline"
        >
          Не подписан?
        </a>
        <!-- Modal -->
        <div
          v-show="isModalOpen"
          class="fixed inset-0 z-30 flex bg-black bg-opacity-50 items-center sm:justify-center"
        >
          <div
            class="w-full px-6 py-4 z-50 overflow-hidden bg-white rounded-lg sm:rounded-lg sm:m-4 sm:max-w-xl"
            role="dialog"
            id="modal"
          >
            <!-- Modal body -->
            <div class="mt-4 mb-6">
              <!-- Modal title -->
              <p
                class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300"
              >
                {{ textResponse }}
              </p>
              <!-- Modal description -->
              <p class="text-sm text-gray-700 dark:text-gray-400"></p>
            </div>
          </div>
        </div>
      </form>

      <label class="inline-block absolute bottom-2 inset-x-0 text-center"
        >Сделано в
        <a href="https://client-turbine.ru" target="_blank" class=""
          >ClientTurbine</a
        ></label
      >
    </main>
  </div>
</template>

<script>
export default {
  props: ["pageProps", "template", "instinfo", "csrf"],
  data() {
    return {
      isModalOpen: false,
      inst: "",
      checkFirstScreen: false,
      textResponse: "Идет поиск вашего аккаунта...",
      intAvatar: null,
    };
  },
  computed: {},
  created() {
    this.checkFirstScreen = localStorage.getItem("check-first-screen");
  },
  methods: {
    closeModal() {
      this.isModalOpen = false;
    },
    openModal() {
      this.isModalOpen = true;
    },
    check() {
      localStorage.getItem("check-first-screen")
        ? (this.checkFirstScreen = true)
        : (this.checkFirstScreen = false);
    },
    setCheck() {
      localStorage.setItem("check-first-screen", true);
      this.checkFirstScreen = true;
    },
    warning(event) {
      this.openModal();
      this.$Progress.start();
      setTimeout(() => {
        this.$Progress.finish();
        localStorage.setItem("check-first-screen", true);
        window.location.href = event.target.href;
      }, 4000);
    },
    searchAk() {
      this.openModal();
      this.$Progress.start();
      console.log(this.inst);
      fetch(`http://127.0.0.1:8001/api/${this.pageProps.url}/check`, {
        method: "POST",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          username: this.inst,
        }),
      })
        .then((response) => {
          if (!response.ok) {
            this.$Progress.fail();
            return response.json();
          }
          this.$Progress.finish();
          return response.json();
        })
        .then((result) => {
          if (result.subscribed) {
            this.textResponse = "Аккаунт найден!";
            document.cookie = `url=${this.pageProps.url}`;
            setTimeout(() => {
              window.location.href = `finish`;
              this.closeModal();
              this.textResponse = "Идет поиск вашего аккаунта...";
            }, 2000);
          } else {
            this.textResponse = "Аккаунт НЕ найден!";
            setTimeout(() => {
              this.closeModal();
              this.textResponse = "Идет поиск вашего аккаунта...";
            }, 2000);
          }
        });
    },
  },
};
</script>

<style>
.size {
  max-height: calc(100vw / 16 * 9 / 2);
}
@media (max-width: 640px) {
  .size {
    max-height: calc(100vw / 16 * 9);
  }
}
.my-mt {
  margin-top: 16vh;
}
</style>
