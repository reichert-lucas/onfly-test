export const ORDER_STATUS = {
    REQUESTED: 1,
    APPROVED: 2,
    CANCELLED: 3
}

export const ORDER_STATUS_LABELS = {
    [ORDER_STATUS.REQUESTED]: 'Solicitado',
    [ORDER_STATUS.APPROVED]: 'Aprovado',
    [ORDER_STATUS.CANCELLED]: 'Cancelado'
}

export const ORDER_STATUS_COLORS = {
    [ORDER_STATUS.REQUESTED]: 'warning',
    [ORDER_STATUS.APPROVED]: 'success',
    [ORDER_STATUS.CANCELLED]: 'error'
}

export const ORDER_STATUS_OPTIONS = [
    {
        value: null,
        label: 'Todos'
    },
    {
        value: ORDER_STATUS.REQUESTED,
        label: ORDER_STATUS_LABELS[ORDER_STATUS.REQUESTED],
        color: ORDER_STATUS_COLORS[ORDER_STATUS.REQUESTED]
    },
    {
        value: ORDER_STATUS.APPROVED,
        label: ORDER_STATUS_LABELS[ORDER_STATUS.APPROVED],
        color: ORDER_STATUS_COLORS[ORDER_STATUS.APPROVED]
    },
    {
        value: ORDER_STATUS.CANCELLED,
        label: ORDER_STATUS_LABELS[ORDER_STATUS.CANCELLED],
        color: ORDER_STATUS_COLORS[ORDER_STATUS.CANCELLED]
    },
]

export const ORDER_STATUS_OPTIONS_WITHOUT_NULL = [
    {
        value: ORDER_STATUS.REQUESTED,
        label: ORDER_STATUS_LABELS[ORDER_STATUS.REQUESTED],
        color: ORDER_STATUS_COLORS[ORDER_STATUS.REQUESTED]
    },
    {
        value: ORDER_STATUS.APPROVED,
        label: ORDER_STATUS_LABELS[ORDER_STATUS.APPROVED],
        color: ORDER_STATUS_COLORS[ORDER_STATUS.APPROVED]
    },
    {
        value: ORDER_STATUS.CANCELLED,
        label: ORDER_STATUS_LABELS[ORDER_STATUS.CANCELLED],
        color: ORDER_STATUS_COLORS[ORDER_STATUS.CANCELLED]
    },
]