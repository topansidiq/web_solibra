function formUser() {
    return {
        name: "",
        id_number: "",
        role: "",
        email: "",
        password: "",
        password_confirmation: "",
        phone_number: "",
        async submitForm() {
            try {
                const response = await axios.post(
                    "/admin/users/store",
                    this.$data
                );
                if (response.data.success) {
                    this.$emit("user-updated", response.data.user);
                    this.resetForm();
                } else {
                    alert(response.data.message || "Failed to update user.");
                }
            } catch (error) {
                console.error(error);
                alert("An error occurred while updating the user.");
            }
        },
        resetForm() {
            this.name = "";
            this.id_number = "";
            this.role = "";
            this.email = "";
            this.password = "";
            this.confirmPassword = "";
            this.phone_number = "";
        },
    };
}
