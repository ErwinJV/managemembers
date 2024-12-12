import { AlpineComponent } from "alpinejs";

import { ManageMember, Members } from "../types";

const DOMAIN = window.location.origin;

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

export const fillUpdateModalInputs = (
  suffix: string,
  id:string,
  name: string,
  lastName: string,
  email: string,
  _document: string,
  memberStatus: string
) => {
  const sendButton = document.getElementById('sendButton') as HTMLDivElement

  const nameInput = document.getElementById(
    `name${suffix}`
  ) as HTMLInputElement;
  const lastNameInput = document.getElementById(
    `lastName${suffix}`
  ) as HTMLInputElement;
  const emailInput = document.getElementById(
    `email${suffix}`
  ) as HTMLInputElement;
  const documentInput = document.getElementById(
    `document${suffix}`
  ) as HTMLInputElement;
  const memberStatusInput = document.getElementById(
    `memberStatus${suffix}`
  ) as HTMLInputElement;
  nameInput.value = name;
  lastNameInput.value = lastName;
  emailInput.value = email;
  documentInput.value = _document;
  memberStatusInput.value = memberStatus;
  sendButton.innerHTML = `<button type="submit" @click="updateMember('${id}')"  >Send</button>`
};

const getInputsValues = (suffix: string) => {
  const name = (document.getElementById(`name${suffix}`) as HTMLInputElement)
    .value;
  const lastName = (
    document.getElementById(`lastName${suffix}`) as HTMLInputElement
  ).value;
  const email = (document.getElementById(`email${suffix}`) as HTMLInputElement)
    .value;
  const _document = (
    document.getElementById(`document${suffix}`) as HTMLInputElement
  ).value;
  const memberStatus = (
    document.getElementById(`memberStatus${suffix}`) as HTMLSelectElement
  ).value;

  return {
    _document,
    email,
    lastName,
    memberStatus,
    name,
  };
};

const validateValues = (values: Record<string, string>) => {
  const _values = Object.values(values);
  let emptyInputs = 0;
  _values.forEach((_value) => {
    if (_value === undefined || _value === null) {
      emptyInputs += 1;
    }
  });

  if (emptyInputs) {
    return false;
  }

  return true;
};

export async function addNewMember  (this:AlpineComponent<ManageMember>) {
  const { _document, email, lastName, memberStatus, name } =
    getInputsValues("_add");

  console.log(window.location.href);
  if (!validateValues({ name, _document, email, lastName, memberStatus })) {
    return
  }
    const newMember = {
      name,
      lastName,
      email,
      document: _document,
      memberStatus,
    };

    await fetch(`${DOMAIN}/wp-json/members/v1/add`, {
      headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
      },
      body: JSON.stringify(newMember),
      method: "POST",
    }).then(async()=>{
      await this.getMembers()
      this.toggleAddModal()
    })  
};

export async  function updateMember  (this:AlpineComponent<ManageMember>,id: string) {
  const { _document, email, lastName, memberStatus, name } =
    getInputsValues("_update");

  const inputsIsValid = validateValues({
    name,
    _document,
    email,
    lastName,
    memberStatus,
  });
  if (!inputsIsValid) {
    return
  }
    const data = {
      id,
      name,
      lastName,
      email,
      document: _document,
      memberStatus,
    };
    console.log(data)
    await fetch(`${DOMAIN}/wp-json/members/v1/update`, {
      headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
      method: "POST",
    }).then(async()=>{
      await this.getMembers()
      this.toggleUpdateModal()
    })
  
    
};

export async function getMembers(this:AlpineComponent<ManageMember>) {
  console.log('offset: ',this.offset, 'limit: ',this.limit,'currentPage: ',this.currentPage,'pages: ',this.pages)
 
  const response = await fetch(
    `${DOMAIN}/wp-json/members/v1/all?limit=${this.limit}&offset=${this.offset}`
  );
  const data = await response.json();
  let rows = "";
  //console.log(data)

  const { members, pages } = JSON.parse(data) as unknown as Members;
  console.log(members)
     
  this.pages = pages
 
  members.forEach((member) => {
    rows += ` <tr>
                <td>${member.name}</td>
                <td>${member.last_name}</td>
                <td>${member.email}</td>
                <td>${member.document}</td>
                <td>${member.member_status}</td>
                <td>${member.created}</td>
                <td class="manage-members-actions">
                 <button @click="toggleUpdateModal(),fillUpdateModalInputs('_update','${member.id}','${member.name}','${member.last_name}','${member.email}','${member.document}','${member.member_status}')">
                   Update
                </button>
                 <button>Delete</button>
                </td>
            </tr>`;
  });

  const tbody = document.getElementById("manageMembersTBody");

  if (tbody) {
    tbody.innerHTML = rows;
  }
}

export function nextPage(this: AlpineComponent<ManageMember>) {

  if(this.currentPage === this.pages -1){
    return
  }
  if (this.showPages[this.showPages.length - 1] !== this.pages) {
    this.showPages = this.showPages.map((value) => value + 1);
  }

  if (this.currentPage === this.pages) {
    return;
  }
  this.currentPage += 1;
  this.offset +=10;

  this.getMembers();
}

export function previousPage(this: AlpineComponent<ManageMember>) {
  if(this.currentPage === 0){
     return
  }
  if (this.showPages[0] !== 1) {
    this.showPages = this.showPages.map((value) => value - 1);
  }
  if(this.currentPage> 0){
    this.currentPage -= 1;
  }
  if(this.offset !== 0){
    this.offset -=10
  }
 


  this.getMembers();
}

export function goToPage(this:AlpineComponent<ManageMember>,page:string){
      if(this.currentPage === parseInt(page) -1){
        return
      }
      this.currentPage = parseInt(page) -1
      if(this.currentPage === 0){
         this.offset = 0
      }else{
       this.offset = this.currentPage * 10
      }
  
      this.getMembers()
}

export function renderPagination(this:AlpineComponent<ManageMember>) {
     const manageMembersPagination = document.getElementById('manageMembersPagination') as HTMLDivElement

     if(this.pages <= 5){
       new Array(this.pages).fill(0).forEach((_,i)=>{
           this.showPages[i] = i+1
       })
     }else{
      new Array(5).fill(0).forEach((_,i)=>{
        this.showPages[i] = i+1
    })
     }

     let paginate = `<span @click="previousPage" class="dashicons dashicons-arrow-left-alt2"></span>`

     this.showPages.forEach((page)=>{
      paginate += `<span class="${page -1 === this.currentPage ? 'current-page' : '' }" @click="goToPage('${page}')">${page}</span>`
     })

     paginate += `<span @click="nextPage()" class="dashicons dashicons-arrow-right-alt2"></span>` 

     manageMembersPagination.innerHTML = paginate

}
