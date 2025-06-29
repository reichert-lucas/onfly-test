import { useLoginStore } from '../stores/login'

export default defineNuxtRouteMiddleware((to, from) => {    
    if (typeof localStorage === 'undefined') {
        return;
    }

    const store = useLoginStore();
    store.checkToken();

    if (to.name !== 'login' && !store.hasToken) {
        toast().error('Não autorizado!', { id: 'login-toast' })
        return navigateTo('/login');
    }

    if (to.name === 'login' && store.hasToken) {
        return navigateTo('/');
    }
})