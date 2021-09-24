<template>
  <div
    class="
      pb-6
      pt-12
      px-6
      sm:w-96
      w-full
      relative
      break-words
      min-h-screen
      md:h-full
      md:shadow-lg
      md:rounded-lg
    "
    :class="template.css_class"
  >
    <vue-progress-bar></vue-progress-bar>
    <div class="inst w-full flex items-center flex-col">
      <img
        v-if="instinfo"
        :src="instinfo.profile_url"
        alt="avatar"
        class="h-20 w-20 overflow-hidden"
        style="border-radius: 50%"
        crossorigin="use-credentials"
      />
      <img v-else src="/img/ava.svg" alt="avatar" />
      <h4 class="font-bold mt-2">{{ instinfo.full_name }}</h4>
      <a
        :href="`https://www.instagram.com/${pageProps.instagram}/`"
        target="_black"
        class="flex items-center"
      >
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
      </a>
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
          class="
            btn-color
            inline-block
            w-full
            mt-6
            px-4
            py-2
            font-medium
            transition-all
            duration-150
            transform
            active:scale-105
            rounded-lg
            focus:outline-none
          "
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
        <transition name="fade">
          <div
            v-if="isModalOpen"
            class="
              fixed
              inset-0
              z-30
              flex
              bg-black bg-opacity-50
              items-center
              sm:justify-center
            "
          >
            <transition name="zoom">
              <div
                class="
                  w-full
                  px-6
                  py-4
                  z-50
                  overflow-hidden
                  bg-white
                  rounded-lg
                  sm:rounded-lg
                  sm:m-4
                  sm:max-w-xl
                "
                role="dialog"
                id="modal"
              >
                <!-- Modal body -->
                <div class="mt-4 mb-6">
                  <!-- Modal title -->
                  <p class="mb-2 text-lg font-semibold text-gray-700">
                    Идет переадресация...
                  </p>
                  <!-- Modal description -->
                  <p class="text-sm text-gray-700">
                    После подписки нажми кнопку "назад" в браузере
                  </p>
                </div>
              </div>
            </transition>
          </div>
        </transition>
      </form>
      <!-- Второй вариант -->
      <form
        v-else
        @submit.prevent="searchAk"
        class="input-container w-full md:max-w-xs md:m-auto mt-4 text-center"
      >
        <input type="hidden" name="_token" :value="csrf" />
        <h2 class="font-bold text-xl leading-5">
          Введите первые буквы вашего логина Instagram:
        </h2>
        <div class="relative">
          <span class="absolute top-10 left-1 text-gray-700">@</span>
          <input
            v-model="inst"
            type="text"
            maxlength="30"
            required
            class="w-full form-input mt-8 text-black focus:outline-none"
            style="padding-left: 1.25rem"
          />
          <div
            v-if="showLastUsername"
            class="
              absolute
              z-30
              w-full
              bg-white
              text-black
              border
              rounded-md
              cursor-pointer
              shadow-md
            "
          >
            <ul class="w-full p-2 overflow-x-auto divide-y">
              <li
                class="py-1"
                v-for="(item, index) in filterUsername"
                :key="index"
                @click="setUsername(item)"
              >
                {{ item }}
              </li>
            </ul>
          </div>
        </div>
        <button
          type="submit"
          class="
            btn-color
            inline-block
            w-full
            mt-2
            px-4
            py-2
            font-medium
            transition-all
            duration-150
            transform
            active:scale-105
            rounded-lg
            focus:outline-none
          "
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
        <transition name="fade">
          <div
            v-if="isModalOpen"
            class="
              fixed
              inset-0
              z-30
              flex
              bg-black bg-opacity-50
              items-center
              sm:justify-center
            "
          >
            <transition name="zoom">
              <div
                v-if="isModalOpen"
                class="
                  w-full
                  px-6
                  py-4
                  z-50
                  overflow-hidden
                  bg-white
                  rounded-lg
                  sm:rounded-lg
                  sm:m-4
                  sm:max-w-xl
                "
                role="dialog"
                id="modal"
              >
                <!-- Modal body -->
                <div class="mt-4 mb-6">
                  <!-- Modal title -->
                  <p class="mb-2 text-lg font-semibold text-gray-700">
                    {{ textResponse }}
                  </p>
                  <!-- Modal description -->
                  <p class="text-sm text-gray-700"></p>
                </div>
              </div>
            </transition>
          </div>
        </transition>
      </form>

      <label
        class="inline-block absolute bottom-2 inset-x-0 text-sm text-center"
        >Сделано в <a href="#" target="_blank" class="">ClientTurbine</a></label
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
      showLastUsername: false,
      checkFirstScreen: false,
      textResponse: "Идет поиск вашего аккаунта...",
      intAvatar: null,
      lastArrUsername: [],
      //   urlAPI: "http://127.0.0.1:8001",
      urlAPI: "https://api.client-turbine.ru",
    };
  },
  computed: {
    filterUsername() {
      return this.lastArrUsername.filter(
        (element) =>
          element.substring(0, this.inst.length) == this.inst.toLowerCase()
      );
    },
  },
  methods: {
    closeModal() {
      this.isModalOpen = false;
    },
    openModal() {
      this.isModalOpen = true;
    },
    setUsername(item) {
      this.inst = item;
      this.showLastUsername = false;
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
        this.closeModal();
      }, 3000);
    },
    searchAk() {
      this.pageProps.fb_pixel ? fbq("trackCustom", "CheckSubButton") : false;
      this.openModal();
      this.$Progress.start();
      console.log(this.inst);
      fetch(`${this.urlAPI}/api/${this.pageProps.url}/check`, {
        method: "POST",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          username: this.inst.toLowerCase(),
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
            this.textResponse =
              "Вы не нажали кнопку 'Подписаться' в Instagram!";
            setTimeout(() => {
              this.closeModal();
              this.textResponse = "Идет поиск вашего аккаунта...";
            }, 2000);
          }
        });
    },
  },
  watch: {
    inst: function (val) {
      if (val.length == 1) {
        fetch(`${this.urlAPI}/api/last`, {
          method: "POST",
          headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            username: this.pageProps.instagram,
          }),
        })
          .then((response) =>
            response.ok ? response.json() : Promise.reject(response)
          )
          .then((result) => {
            this.lastArrUsername = result.data;
          })
          .catch((error) => {
            console.log("Данные с сервера не получены");
            throw error;
          });
      }

      if (
        val.length > 1 &&
        this.filterUsername.length &&
        this.filterUsername != val
      ) {
        this.showLastUsername = true;
      } else {
        this.showLastUsername = false;
      }
    },
  },
  created() {
    this.checkFirstScreen = localStorage.getItem("check-first-screen");
  },
};
</script>

<style>
.my-mt {
  margin-top: 16vh;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}

.zoom-enter-active,
.zoom-leave-active {
  animation-duration: 0.8s;
  animation-fill-mode: both;
  animation-name: zoom;
}

.zoom-leave-active {
  animation-direction: reverse;
}

@keyframes zoom {
  from {
    opacity: 0;
    transform: scale3d(0.3, 0.3, 0.3);
  }

  100% {
    opacity: 1;
  }
}
</style>
