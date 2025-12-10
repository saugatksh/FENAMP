async function loadCommittee(sectionName) {
    try {
        const response = await fetch("team.json");
        const data = await response.json();

        const members = data[sectionName];
        const container = document.getElementById("committee-container");

        container.innerHTML = ""; // Clear previous content

        if (!members || members.length === 0) {
            container.innerHTML = "<p>No data found for this committee.</p>";
            return;
        }

        // Separate president (or first featured member) from others
        const president = members.find(member => member.title.toLowerCase() === "president") || members[0];
        const others = members.filter(member => member !== president);

        // 1️⃣ Render president/featured member
        const emailHTMLPresident = president.email ? `<br><small>Email: <a href="mailto:${president.email}">${president.email}</a></small>` : '';
        const featuredHTML = `
            <div class="row justify-content-center mb-5">
                <div class="col-12 col-sm-8 col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="team-item d-flex h-100 p-4 text-center">
                        <div class="team-detail">
                            <img class="img-fluid mb-4" src="${president.image}" alt="${president.name}">
                            <h3>${president.name}</h3>
                            <span>${president.title}</span>
                            ${emailHTMLPresident}
                        </div>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', featuredHTML);

        // 2️⃣ Render remaining members in a grid
        const gridHTML = others.map((member, index) => {
            const delay = (0.1 + index * 0.1).toFixed(1);
            const emailHTML = member.email ? `<br><small>Email: <a href="mailto:${member.email}">${member.email}</a></small>` : '';
            return `
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="${delay}s">
                    <div class="team-item d-flex h-100 p-4">
                        <div class="team-detail pe-4">
                            <img class="img-fluid mb-4" src="${member.image}" alt="${member.name}">
                            <h3>${member.name}</h3>
                            <span>${member.title}</span>
                            ${emailHTML}
                        </div>
                    </div>
                </div>
            `;
        }).join('');

        if (others.length > 0) {
            container.insertAdjacentHTML('beforeend', `<div class="row">${gridHTML}</div>`);
        }

        // 3️⃣ Re-initialize WOW.js for dynamically added content
        new WOW().init();

    } catch (error) {
        console.error("Error loading committee:", error);
    }
}
