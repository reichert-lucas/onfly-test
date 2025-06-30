<template>
    <v-container class="containter w-100 h-100 pt-10">        
        <div class="d-flex align-center justify-space-between mb-4">
            <h2>Dashboard</h2>

            <v-btn
                class="text-white"
                color="blue"
                rounded
                large
                @click="openForm()"
            >
                <v-icon class="mr-2">
                    mdi-account-plus
                </v-icon>
                Adicionar novo pedido
            </v-btn>
        </div>

        <div class="d-flex align-center justify-space-between mb-2">
            <v-text-field
                variant="underlined"
                :color="dark ? 'white' : 'blue'"
                label="Buscar pedido..."
                append-icon="mdi-magnify"
                @keydown.enter="search(true)"
                v-model="filters.search"
            >
                <template v-slot:loader>
                    <v-progress-linear
                        color="blue"
                        height="7"
                        indeterminate
                        :active="loading"
                    />
                </template> 
            </v-text-field>
        </div>

        <div class="d-flex align-center justify-space-between mb-0 flex-wrap">
            <v-text-field
                class="ma-1"
                label="Data de ida (inicial)"
                type="text"
                v-maska:[dateMask]
                v-model="departureDate"
                placeholder="DD/MM/AAAA"
            />

            <v-text-field
                v-if="departureDate && departureDate.length >= 10"
                class="ma-1"
                label="Data de retorno (final)"
                type="text"
                v-maska:[dateMask]
                v-model="returnDate"
                placeholder="DD/MM/AAAA"
            />
        </div>

        <div class="d-flex align-center justify-space-between mb-0 flex-wrap">
            <v-select
                class="ma-1"
                label="Status"
                item-title="label"
                item-value="value"
                :items="ORDER_STATUS_OPTIONS"
                v-model="filters.status_id"
                @input="search(true)"
            />
        </div>


        <div class="d-flex align-center justify-space-between mb-8 flex-wrap">
            <v-btn
                @click="search(true)"
                :loading="loading"
                prepend-icon="mdi-magnify"
                block
                color="blue"
                class="text-white text-weight-bold"
                style="color:white;"
                :elevation="8"
            >
                <b>Consultar</b>
            </v-btn>
        </div>

        <div v-if="orders.length">
            <v-table fixed-header class="w-full" hover>
                <thead>
                <tr>
                    <th class="text-left font-weight-black">Solicitante</th>
                    <th class="text-left font-weight-black">Destino</th>
                    <th class="text-left font-weight-black">Data de Ida</th>
                    <th class="text-left font-weight-black">Data de Volta</th>
                    <th class="text-right font-weight-black">Status</th>
                </tr>
                </thead>
                <tbody>
                <tr
                    v-for="order in orders"
                    :key="order.id"
                >
                    <td><b>{{ order.applicant.name }}</b></td>
                    <td>{{ order.destination }}</td>
                    <td>{{ order.departure_date }}</td>
                    <td>{{ order.return_date }}</td>
                    <td v-if="user().is_admin || user().is_super_admin" class="d-flex justify-end align-center">
                        <v-menu>
                            <template v-slot:activator="{ props }">
                                <v-chip
                                    :color="order.status.color"
                                    size="small"
                                    variant="flat"
                                    v-bind="props"
                                    style="cursor: pointer"
                                >
                                    <span>{{ order.status?.name || 'Pendente' }}</span>
                                    <v-progress-circular
                                        v-if="changingStatus[order.id]"
                                        indeterminate
                                        size="16"
                                        width="2"
                                        color="white"
                                        class="ml-2"
                                    />
                                    <v-icon
                                        v-else-if="getStatusAvailableList(order.status?.id).length && order.applicant.id !== user().id"
                                        class="ml-2"
                                        style="font-size:16px;"
                                        icon="mdi-sync"
                                    />
                                </v-chip>
                            </template>
                            <v-list v-if="order.applicant.id !== user().id">
                                <v-list-item
                                    v-for="status in getStatusAvailableList(order.status?.id)"
                                    :key="status.id"
                                    @click="changeStatus(order.id, status.value)"
                                    :disabled="order.status?.id === status.value || changingStatus[order.id]"
                                >
                                    <v-list-item-title>
                                        <v-chip
                                            :color="status.color"
                                            size="small"
                                            variant="flat"
                                        >
                                            {{ status.label }}
                                        </v-chip>
                                    </v-list-item-title>
                                </v-list-item>
                            </v-list>
                        </v-menu>
                    </td>
                    <td v-else class="d-flex justify-end align-center">
                        <v-chip
                            :color="order.status.color"
                            size="small"
                            variant="flat"
                        >
                            <span>{{ order.status?.name || 'Pendente' }}</span>
                        </v-chip>
                    </td>
                </tr>
                </tbody>
            </v-table>
    
            <v-pagination
                class="mt-4"
                :color="dark ? 'white' : 'blue'"
                :length="this.last_page"
                v-model="page"
            />
        </div>

        <div v-else class="d-flex justify-center align-center flex-column mt-14">
            <v-icon style="font-size:64px;" class="mb-4">mdi-cylinder-off</v-icon>
            <span class="mb-4">Ops! Nenhum pedido encontrado.</span>
            <v-btn
                class="text-white"
                color="blue"
                rounded
                large
                @click="openForm()"
            >
                <v-icon class="mr-2">
                    mdi-account-plus
                </v-icon>
                Adicionar novo pedido
            </v-btn>
        </div>

        <modals-travel-order-modal
            v-if="showForm"
            :show="showForm"
            @close="closeForm"
            @refreshOrders="search(true)"
        />
    </v-container>
</template>


<script>
import ChangeTheme from '@/mixins/ChangeTheme.vue'
import { ORDER_STATUS_OPTIONS, ORDER_STATUS_OPTIONS_WITHOUT_NULL, ORDER_STATUS } from '@/constants/order-status'

export default {
    mixins: [ ChangeTheme ],

    data () {
        return {
            loading: false,
            orders: [],
            page: 1,
            showForm: false,
            changingStatus: [],
            filters: {
                search: null,
                departure_date: null,
                return_date: null,
                status_id: null,
            },
            departureDate: null,
            returnDate: null,
            dateMask: { mask: '##/##/####' },
            ORDER_STATUS_OPTIONS
        }
    },

    created () {            
        this.search()
    },

    methods: {
        formatDateForAPI(dateString) {
            if (!dateString) return null;

            const [day, month, year] = dateString.split('/');
            return `${year}-${month}-${day}`;
        },

        search(resetPagination = false){
            this.loading = true

            if (resetPagination) this.page = 1;

            this.filters.page = this.page;
            this.filters.departure_date = this.formatDateForAPI(this.departureDate);
            this.filters.return_date = this.formatDateForAPI(this.returnDate);

            api().get(`${user().is_admin || user().is_super_admin ? 'admins' : 'users'}/travel-orders`, {
                params: this.filters
            })
                .then(res => {
                    this.orders = res.data.data
                    this.page = res.data.meta.current_page
                    this.last_page = res.data.meta.last_page
                    this.total_items = res.data.meta.total
                })
                .catch(() => {
                    toast().error('Erro ao buscar pedidos')
                })
                .finally(() => this.loading = false)
        },

        openForm()
        {
            this.showForm = true
        },

        closeForm()
        {
            this.showForm = false
        },

        changeStatus(orderId, newStatus) {
            this.changingStatus[orderId] = true;

            api().patch(`admins/travel-orders/${orderId}/change-status`, {
                status_id: newStatus
            })
                .then(() => {
                    this.search()
                    toast().success('Status atualizado com sucesso')
                })
                .catch((error) => {
                    toast().error(getMessageError(error));
                })
                .finally(() => {
                    this.changingStatus[orderId] = false;
                })
        },

        getStatusAvailableList(currentStatus) {
            const allowedTransitions = {
                [ORDER_STATUS.REQUESTED]: [ORDER_STATUS.APPROVED, ORDER_STATUS.CANCELLED],
                [ORDER_STATUS.APPROVED]: [ORDER_STATUS.CANCELLED],
                [ORDER_STATUS.CANCELLED]: []
            }

            return ORDER_STATUS_OPTIONS_WITHOUT_NULL.filter(option => 
                allowedTransitions[currentStatus]?.includes(option.value)
            )
        }
    },

    watch: {
        page() {
            this.search()
        }
    }
}
</script>