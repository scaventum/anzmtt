import React from "react";
import { defaultTheme } from "@/config/theme";

export default function ExecutiveCommitteeBlock({
    data,
    executiveCommitteeMembers = [],
    theme = defaultTheme,
}) {
    return (
        <section className="flex flex-col gap-8">
            {/* Members Grid */}
            <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                {executiveCommitteeMembers.map((member) => {
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
                                </div>
                            </div>

                            {/* Bio */}
                            {member.bio && (
                                <p className="text-sm text-gray-700">
                                    {member.bio}
                                </p>
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
                        </div>
                    );
                })}
            </div>
        </section>
    );
}
