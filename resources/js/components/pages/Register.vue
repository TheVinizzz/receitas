<template>
  <div class="min-h-[calc(100vh-4rem)] bg-gradient-to-br from-orange-50 via-white to-red-50 flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
      <div class="bg-white rounded-2xl shadow-2xl p-8 border border-gray-100">
        <div class="flex justify-center mb-6">
          <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl flex items-center justify-center">
            <UserPlus :size="32" class="text-white" />
          </div>
        </div>
        
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-2">Criar Conta</h2>
        <p class="text-center text-gray-600 mb-8">Junte-se ao RecipeHub hoje</p>
        
        <form @submit.prevent="handleSubmit" class="space-y-5">
          <div v-if="error" class="flex items-start space-x-3 p-4 bg-red-50 border border-red-200 rounded-xl">
            <AlertCircle :size="20" class="text-red-600 flex-shrink-0 mt-0.5" />
            <span class="text-sm text-red-800">{{ error }}</span>
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2" for="name">
              Nome Completo
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <User :size="20" class="text-gray-400" />
              </div>
              <input
                id="name"
                v-model="form.name"
                type="text"
                required
                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                placeholder="Seu nome completo"
              >
            </div>
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2" for="email">
              E-mail
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <Mail :size="20" class="text-gray-400" />
              </div>
              <input
                id="email"
                v-model="form.email"
                type="email"
                required
                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                placeholder="seu@email.com"
              >
            </div>
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2" for="password">
              Senha
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <Lock :size="20" class="text-gray-400" />
              </div>
              <input
                id="password"
                v-model="form.password"
                type="password"
                required
                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                placeholder="••••••••"
              >
            </div>
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2" for="password_confirmation">
              Confirmar Senha
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <Lock :size="20" class="text-gray-400" />
              </div>
              <input
                id="password_confirmation"
                v-model="form.password_confirmation"
                type="password"
                required
                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                placeholder="••••••••"
              >
            </div>
          </div>

          <button
            type="submit"
            :disabled="loading"
            class="w-full flex items-center justify-center space-x-2 px-6 py-3 bg-gradient-to-r from-orange-500 to-red-600 text-white rounded-xl hover:from-orange-600 hover:to-red-700 transition-all shadow-lg hover:shadow-xl font-semibold disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <Loader2 v-if="loading" :size="20" class="animate-spin" />
            <UserPlus v-else :size="20" />
            <span>{{ loading ? 'Criando conta...' : 'Criar Conta' }}</span>
          </button>
        </form>

        <div class="mt-6 text-center">
          <span class="text-gray-600">Já tem uma conta? </span>
          <router-link to="/login" class="text-orange-600 hover:text-orange-700 font-semibold">
            Entrar
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../../stores/auth';
import { UserPlus, User, Mail, Lock, AlertCircle, Loader2 } from 'lucide-vue-next';

export default {
  name: 'Register',
  components: {
    UserPlus,
    User,
    Mail,
    Lock,
    AlertCircle,
    Loader2
  },
  setup() {
    const router = useRouter();
    const authStore = useAuthStore();
    
    const form = ref({
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
    });
    
    const error = ref('');
    const loading = ref(false);

    const handleSubmit = async () => {
      if (form.value.password !== form.value.password_confirmation) {
        error.value = 'As senhas não coincidem';
        return;
      }

      error.value = '';
      loading.value = true;
      
      try {
        await authStore.register(form.value);
        router.push('/recipes');
      } catch (err) {
        error.value = err.response?.data?.message || 'Erro ao criar conta';
      } finally {
        loading.value = false;
      }
    };

    return {
      form,
      error,
      loading,
      handleSubmit,
    };
  },
};
</script>
