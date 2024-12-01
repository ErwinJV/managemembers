import { AlpineComponent } from "alpinejs"

import { ManageMember } from "../types"

export const deleteMember = (url: string) => {
  window.location.href = url
}

export function toggleUpdateModal(this:AlpineComponent<ManageMember>) {
    console.log(this.openUpdateModal)
    this.openUpdateModal = !this.openUpdateModal
    console.log(this.openUpdateModal)
}

export function toggleAddModal(this:AlpineComponent<ManageMember>){
    console.log(this.openAddModal)
    this.openAddModal = !this.openAddModal
    console.log(this.openAddModal)
}

export const fillUpdateModalInputs = (name:string) =>{
    const nameInput = document.getElementById('name') as HTMLInputElement
    nameInput.value = name
}
