import { AlpineComponent } from "alpinejs";

import { ManageMember } from "../types";

export const deleteMember = (url: string) => {
  window.location.href = url;
};

export function toggleUpdateModal(this: AlpineComponent<ManageMember>) {
  console.log(this.openUpdateModal);
  this.openUpdateModal = !this.openUpdateModal;
  console.log(this.openUpdateModal);
}

export function toggleAddModal(this: AlpineComponent<ManageMember>) {
  console.log(this.openAddModal);
  this.openAddModal = !this.openAddModal;
  console.log(this.openAddModal);
}

export const fillUpdateModalInputs = (name: string) => {
  const nameInput = document.getElementById("name") as HTMLInputElement;
  nameInput.value = name;
};

export const addNewMember = async() => {
  const name = (document.getElementById("name_add") as HTMLInputElement).value;
  const lastName = (document.getElementById("lastName_add") as HTMLInputElement)
    .value;
  const email = (document.getElementById("email_add") as HTMLInputElement)
    .value;
  const _document = (
    document.getElementById("document_add") as HTMLInputElement
  ).value;
  const memberStatus = (
    document.getElementById("memberStatus_add") as HTMLSelectElement
  ).value;

  const domain = window.location.origin;
  
   //@ts-ignore
  

  if (
    name &&
    lastName &&
    email &&
    _document &&
    memberStatus
  ) {
    const newMember = {
      name,
      lastName,
      email,
      document: _document,
      memberStatus,
    };

    const response = await fetch(`${domain}/wp-json/members/v1/add`, {
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            //@ts-ignore
            'Nonce': wpApiAuth.nonce
          },
        body:JSON.stringify(newMember),
        method:'POST', 
         
    })

    const json = await response.json()
    console.log(json)
  }else{
    //@ts-ignore
     console.log(wpApiAuth.nonce)
  }
};
