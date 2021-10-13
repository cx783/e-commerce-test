<template>
  <div class="flex flex-wrap space-x-2">
    <div class="w-32 h-24 relative overflow-hidden" v-for="(file, index) in filesPreview" :key="`prev_${index}`">
      <img :src="file" class="w-full rounded" />
      <div v-if="uploaded.includes(index)"
        class="w-6 h-6 flex justify-center items-center rounded-full absolute top-2 right-2 bg-green-400 text-white"
      >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
      </div>
      <div v-if="failed.includes(index)"
        class="w-6 h-6 flex justify-center items-center rounded-full absolute top-2 right-2 bg-red-400 text-white"
      >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
      </div>
    </div>
    <div class="w-32 h-24 border rounded border-gray-300 relative">
      <div class="w-full h-full flex flex-col justify-center items-center absolute top-0 left-0 z-0">
        <loader v-if="noConfirm && uploading" color="green-100"></loader>
        <svg v-else class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
        <slot name="text"><span class="text-sm text-gray-800">Choose a file</span></slot>
      </div>
      <input type="file"
        multiple
        ref="inputFile"
        name="inputFile"
        id="inputFile"
        @input="changed"
        class="w-full h-full absolute top-0 left-0 opacity-0 z-10"
        accept="image/png, image/jpeg"
      />
    </div>
    <form-button v-if="files.length > 0 && ! noConfirm"
      class="w-32 h-24 flex space-x-2 items-center"
      color="green"
      @click="confirm"
    >
      <loader v-if="uploading" color="green-100"></loader>
      <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
      <span>Confirm</span>
    </form-button>
  </div>
</template>

<script>
import FormButton from './Button.vue'
import axios from 'axios'

export default {
  props: {
    url: {
      type: String,
      required: true
    },
    noConfirm: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      files: [],
      uploaded: [],
      failed: [],
      uploading: false
    }
  },
  components: {
    FormButton
  },
  computed: {
    filesPreview() {
      let prev = []
      if (this.files.length > 0) {
        for (let i = 0; i < this.files.length; i++) {
          prev.push(URL.createObjectURL(this.files.item(i)))
        }
      } else {
        prev = []
      }

      return prev
    }
  },
  methods: {
    changed() {
      console.log(this.$refs.inputFile.files)
      this.files = this.$refs.inputFile.files
    },
    // Warning: this method can be called from parent with ref
    async confirm() {
      this.uploading = true
      let calls = []

      for (let i = 0; i < this.files.length; i++) {
        let fd = new FormData();
        fd.append('file', this.files.item(i))

        const res = axios.post(this.url, fd, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        }).then(res => {
          this.uploaded.push(i)
        }).catch(err => {
          this.failed.push(i)
        })

        calls.push(res)
      }

      Promise.all(calls).then(r => {
        setTimeout(() => {
          this.files = []
          this.uploaded = []
          this.failed = []
        }, 1500)

      }).finally(() => {
        this.uploading = false
        this.$emit('uploaded')
      })
    }
  }
}
</script>
