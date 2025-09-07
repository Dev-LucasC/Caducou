import { createRouter, createWebHistory } from 'vue-router'

// Import das pages
import PageInicio from '../pages/PageInicio.vue'
import DinheiroEmprestado from '../pages/DinheiroEmprestado.vue'
import VendasRealizadas from '../pages/VendasRealizadas.vue'
import UserConsolidacaoValores from '../pages/UserConsolidacaoValores.vue'
import UserInfos from '../pages/UserInfos.vue'

// Modals como páginas (apenas para teste visual)
import CriarVenda from '../pages/modals/CriarVenda.vue'
import CriarEmprestimo from '../pages/modals/CriarEmprestimo.vue'
import EncerrarVenda from '../pages/modals/EncerrarVenda.vue'
import EncerrarEmprestimo from '../pages/modals/EncerrarEmprestimo.vue'
import EditarInformacoes from '../pages/modals/EditarInformacoes.vue'

const routes = [
  { path: '/', name: 'Inicio', component: PageInicio },
  { path: '/dinheiro-emprestado', name: 'DinheiroEmprestado', component: DinheiroEmprestado },
  { path: '/vendas-realizadas', name: 'VendasRealizadas', component: VendasRealizadas },
  { path: '/user-consolidacao-valores', name: 'UserConsolidacaoValores', component: UserConsolidacaoValores },
  { path: '/user-infos', name: 'UserInfos', component: UserInfos },

  // Rotas de modals
  { path: '/criar-venda', name: 'CriarVenda', component: CriarVenda },
  { path: '/criar-emprestimo', name: 'CriarEmprestimo', component: CriarEmprestimo },
  { path: '/encerrar-venda', name: 'EncerrarVenda', component: EncerrarVenda },
  { path: '/encerrar-emprestimo', name: 'EncerrarEmprestimo', component: EncerrarEmprestimo },
  { path: '/editar-informacoes', name: 'EditarInformacoes', component: EditarInformacoes },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
