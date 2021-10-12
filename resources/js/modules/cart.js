export default {
  namespaced: true,
  state: {
    items: [/**{
      quantity: 1,
      product: {
        id: '',
        name: '',
        image: '',
        price: 1
      }
    }*/]
  },
  getters:{
    totalItems(state) {
      return state.items.reduce((acc, i) => acc + i.quantity, 0)
    },
    total(state) {
      return state.items.reduce((acc, i) => acc + (i.quantity * i.product.price), 0)
    }
  },
  mutations: {
    addItem(state, { product, quantity = 1 }) {
      let item = state.items.find(i => i.product.id === product.id)

      if (typeof item === 'undefined') {
        state.items.push({
          quantity,
          product: {
            id: product.id,
            name: product.name,
            image: product.images[0],
            price: product.price
          }
        })
      } else {
        item.quantity = item.quantity + 1
      }
    },
    removeItem(state, productId) {
      state.items = state.items.filter(i => i.product.id !== productId)
    } 
  }
}