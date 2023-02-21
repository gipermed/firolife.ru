import Vue from 'vue';
import Vuex from 'vuex';
import {makeFormData, postRequest} from "../helpers/axios";

Vue.use(Vuex);

// noinspection JSCheckFunctionSignatures
export default new Vuex.Store({
    state: {
        products: [],

        initialized: false,
    },
    actions: {
        initialize: ({state}, products) => {
            if (state.initialized) {
                return;
            }

            state.products = products;

            state.initialized = true;
        },


        changeProduct: ({dispatch, commit, getters}, product) => {
            return new Promise((resolve, reject) => {
                postRequest(makeFormData('change-offer-in-basket', {
                    fromId: product.fromId,

                    toId: product.toId,
                    quantity: product.quantity,

                    baseProductId: product.productId,
                }))
                    .then(response => {
                        let oldProduct = getters.getProductById(product.fromId);
                        if (oldProduct) {
                            commit('removeProduct', product.fromId);
                        }

                        let existedProduct = getters.getProductById(product.toId);
                        if (!existedProduct) {
                            commit('addProduct', {id: product.toId, ...product});
                        } else {
                            commit('updateQuantity', {
                                id: existedProduct.id,
                                quantity: product.quantity,
                            });
                        }

                        resolve(response.data);
                    })
                    .catch(response => {
                        reject(response.data);
                    });
            })
        },
        addProduct: ({commit, getters}, product) => {
            return new Promise((resolve, reject) => {
                postRequest(makeFormData('add-to-basket', {
                    id: product.id,
                    quantity: product.quantity,

                    baseProductId: product.productId,
                }))
                    .then(response => {
                        let existedProduct = getters.getProductById(product.id);

                        if (!existedProduct) {
                            commit('addProduct', product);
                        } else {
                            commit('updateQuantity', {
                                id: existedProduct.id,
                                quantity: existedProduct.quantity + product.quantity,
                            });
                        }

                        resolve(response.data);
                    })
                    .catch(response => {
                        reject(response.data);
                    });
            })
        },
        removeProduct: ({commit}, id) => {
            return new Promise((resolve, reject) => {
                postRequest(makeFormData('delete-from-basket', {id}))
                    .then(response => {
                        commit('removeProduct', id);

                        resolve(response.data);
                    })
                    .catch(response => {
                        reject(response.data);
                    });
            })
        },
        updateQuantity: ({commit}, updatedProduct) => {
            return new Promise((resolve, reject) => {
                postRequest(makeFormData('set-basket-quantity', {
                    id: updatedProduct.id,
                    quantity: updatedProduct.quantity,
                }))
                    .then(response => {
                        commit('updateQuantity', updatedProduct);

                        resolve(response.data);
                    })
                    .catch(response => {
                        reject(response.data);
                    });
            });
        },
        clear: ({commit}) => {
            return new Promise((resolve, reject) => {
                postRequest(makeFormData('clear-cart'))
                    .then(response => {
                        commit('clear');

                        resolve(response.data);
                    })
                    .catch(response => {
                        reject(response.data);
                    });
            });
        }
    },
    mutations: {
        addProduct: (state, product) => state.products.push(product),

        removeProduct: (state, productId) => state.products = state.products.filter(product => {
            return Number(product.id) !== Number(productId);
        }),

        updateQuantity: (state, updatedProduct) => state.products = state.products.map(product => {

            if (Number(product.id) === Number(updatedProduct.id)) {
                product.quantity = updatedProduct.quantity;
            }

            return product;
        }),

        clear: state => {
            state.products = [];
        }
    },
    getters: {
        getProductByBaseId: state => id => state.products.find(product => Number(product.baseProductId) === Number(id)),
        getProductById: state => id => state.products.find(product => Number(product.id) === Number(id)),

        productInBasket: (state, getters) => id => !!getters.getProductById(id),

        isEmpty: state => !state.products.length,

        summary: state => state.products.reduce((summary, product) => {
            return summary + (Number(product.price) * product.quantity);
        }, 0),
        summaryFormatted: (state, getters) => `${new Intl.NumberFormat('ru-RU').format(getters.summary)} ₽`,

        summaryUSD: state => state.products.reduce((summary, product) => {
            return summary + (Number(product.priceUSD) * product.quantity);
        }, 0),
        summaryUSDFormatted: (state, getters) => `$ ${new Intl.NumberFormat('ru-RU').format(getters.summaryUSD)}`,

        count: state => state.products.length,

        initialized: state => () => new Promise((resolve) => {
            let interval;

            interval = setInterval(function () {
                if (state.initialized) {
                    resolve();

                    clearInterval(interval);
                }
            }, 100);
        }),
    }
});
