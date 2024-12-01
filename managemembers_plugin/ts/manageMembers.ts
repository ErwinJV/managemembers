import Alpine, { AlpineComponent } from "alpinejs"

import {ManageMember} from './types'
import {deleteMember,fillUpdateModalInputs,toggleAddModal,toggleUpdateModal} from './helpers'

//@ts-ignore
window.Alpine = Alpine

Alpine.data('manageMembers',():AlpineComponent<ManageMember>=>({
    deleteMember,
    fillUpdateModalInputs,
    openAddModal:false,
    openUpdateModal:false,
    toggleAddModal,
    toggleUpdateModal,
}))

Alpine.start()
