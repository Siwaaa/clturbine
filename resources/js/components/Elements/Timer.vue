<template>
  <div v-if="minute !== null" class="timer w-full mt-14">
    <p class="mb-2">
      {{timer_text}}
      <span>{{ minute }}:{{ (remainedSec % 60 &lt; 10) ? '0'+second : second }}</span>
    </p>
    <div class="h-2 w-full bg-black bg-opacity-40 overflow-hidden rounded-lg">
      <div
        class="timeline h-full bg-red-500"
        :style="{ width: widthTimeline }"
      ></div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Timer",
  props: {
    timer_text: {
      type: String,
      default: 'Материал закроется'
    },
    timer_sec: {
      type: Number,
      default: 60
    },
  },
  data() {
    return {
      remainedSec: null,
      minute: null,
      second: null,
      widthTimeline: "100%",
    };
  },
  methods: {
    timerGo() {
      let timer = setInterval(() => {
        if (--this.remainedSec >= 0) {
          this.widthTimeline =
            100 -((this.timer_sec - this.remainedSec) / this.timer_sec) * 100 +
            "%";
          this.minute = Math.floor(this.remainedSec / 60);
          this.second = this.remainedSec % 60;
        } else {
          clearInterval(timer);
        }
      }, 1000);
    },
  },
  mounted() {
    this.timerGo();
    this.remainedSec = this.timer_sec;
  },
};
</script>