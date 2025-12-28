import React, { useMemo, useState } from "react";
import { defaultTheme } from "@/config/theme";

export default function MemberDirectoryBlock({
    data,
    members = [],
    theme = defaultTheme,
}) {
    const [sortBy, setSortBy] = useState("name-asc");
    const [search, setSearch] = useState("");

    const visibleMembers = useMemo(() => {
        const query = search.trim().toLowerCase();

        let filtered = members;

        if (query) {
            filtered = members.filter((member) => {
                const fullName =
                    `${member.first_name} ${member.last_name}`.toLowerCase();
                return fullName.includes(query);
            });
        }

        const copy = [...filtered];

        switch (sortBy) {
            case "name-asc":
                return copy.sort((a, b) =>
                    `${a.first_name} ${a.last_name}`.localeCompare(
                        `${b.first_name} ${b.last_name}`,
                        undefined,
                        { sensitivity: "base" }
                    )
                );

            case "name-desc":
                return copy.sort((a, b) =>
                    `${b.first_name} ${b.last_name}`.localeCompare(
                        `${a.first_name} ${a.last_name}`,
                        undefined,
                        { sensitivity: "base" }
                    )
                );

            case "last-active-newest":
                return copy.sort(
                    (a, b) =>
                        new Date(b.last_active_at || 0) -
                        new Date(a.last_active_at || 0)
                );

            case "last-active-oldest":
                return copy.sort(
                    (a, b) =>
                        new Date(a.last_active_at || 0) -
                        new Date(b.last_active_at || 0)
                );

            default:
                return copy;
        }
    }, [members, sortBy, search]);

    return (
        <section className="flex flex-col gap-8">
            <div className="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                {/* Search */}
                <div className="flex items-center gap-2">
                    <label
                        htmlFor="member-search"
                        className="text-sm font-medium text-gray-700"
                    >
                        Search:
                    </label>
                    <input
                        id="member-search"
                        type="text"
                        value={search}
                        onChange={(e) => setSearch(e.target.value)}
                        placeholder="First or last name"
                        className="rounded-md border border-gray-300 px-3 py-2 text-sm"
                    />
                </div>

                {/* Sort */}
                <div className="flex items-center gap-2">
                    <label
                        htmlFor="member-sort"
                        className="text-sm font-medium text-gray-700"
                    >
                        Sort by:
                    </label>
                    <select
                        id="member-sort"
                        value={sortBy}
                        onChange={(e) => setSortBy(e.target.value)}
                        className="rounded-md border border-gray-300 px-3 py-2 text-sm"
                    >
                        <option value="name-asc">Name (A–Z)</option>
                        <option value="name-desc">Name (Z–A)</option>
                        <option value="last-active-newest">
                            Last Active (Newest)
                        </option>
                        <option value="last-active-oldest">
                            Last Active (Oldest)
                        </option>
                    </select>
                </div>
            </div>

            {/* Members Grid */}
            <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                {visibleMembers.map((member) => {
                    const avatar = member.avatar
                        ? `/storage/${member.avatar}`
                        : `https://ui-avatars.com/api/?name=${encodeURIComponent(
                              `${member.first_name} ${member.last_name}`
                          )}&background=ddd&color=555&rounded=true&size=128`;

                    return (
                        <div
                            key={member.id}
                            className="flex flex-col gap-4 rounded-xl bg-white p-6 shadow transition hover:shadow-lg"
                        >
                            {/* Avatar + Name */}
                            <div className="flex items-center gap-4">
                                <img
                                    src={avatar}
                                    alt={`${member.first_name} ${member.last_name}`}
                                    className="h-24 w-24 rounded-full object-cover" // increased size
                                />

                                <div>
                                    <h3 className="text-lg font-semibold text-gray-900">
                                        {member.title && (
                                            <span className="mr-1">
                                                {member.title}
                                            </span>
                                        )}
                                        {member.first_name} {member.last_name}
                                    </h3>

                                    {member.role && (
                                        <p className="text-sm text-gray-600">
                                            {member.role}
                                        </p>
                                    )}

                                    {member.organisation && (
                                        <p className="text-sm text-gray-500">
                                            {member.organisation}
                                        </p>
                                    )}
                                </div>
                            </div>

                            {/* Bio */}
                            {member.bio && (
                                <p className="text-sm text-gray-700">
                                    {member.bio}
                                </p>
                            )}

                            {/* Interests */}
                            {member.interests &&
                                member.interests.length > 0 && (
                                    <div className="pt-2">
                                        <h4 className="text-sm font-semibold text-gray-700 mb-1">
                                            Interests:
                                        </h4>
                                        <ul className="list-disc list-inside text-sm text-gray-700 space-y-1">
                                            {member.interests.map(
                                                (interest, index) => (
                                                    <li key={index}>
                                                        {interest}
                                                    </li>
                                                )
                                            )}
                                        </ul>
                                    </div>
                                )}

                            {/* Contact */}
                            {member.email && (
                                <div className="pt-2">
                                    <a
                                        href={`mailto:${member.email}`}
                                        className={`text-sm font-medium transition ${theme.text.primary} hover:underline`}
                                    >
                                        {member.email}
                                    </a>
                                </div>
                            )}

                            {/* Last Active */}
                            {member.last_active_at && (
                                <p className="text-xs text-gray-500 pt-1">
                                    Last active:{" "}
                                    {new Date(
                                        member.last_active_at
                                    ).toLocaleDateString(undefined, {
                                        year: "numeric",
                                        month: "short",
                                        day: "numeric",
                                        hour: "2-digit",
                                        minute: "2-digit",
                                    })}
                                </p>
                            )}
                        </div>
                    );
                })}
            </div>
        </section>
    );
}
