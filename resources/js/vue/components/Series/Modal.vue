<template>
    <section>
      <div class="odocs-spaced">
        <o-button size="medium" variant="primary" @click="imageModal()">
          Open modal (HTML)
        </o-button>
      </div>
    </section>
  </template>
  
  <script lang="ts">
  import { defineComponent, h } from 'vue'
  import { useProgrammatic } from '@oruga-ui/oruga-next'
  
  export default defineComponent({
    setup() {
  
      const { oruga } = useProgrammatic()
  
      function imageModal() {
        const vnode = h('p', { style: { 'text-align': 'center' } }, [
          h('img', { src: 'https://avatars2.githubusercontent.com/u/66300512?s=200&v=4' })
        ])
        oruga.modal.open({
          content: [vnode]
        })
      }
  
      return {
        imageModal,
      }
    }
  })
  </script>