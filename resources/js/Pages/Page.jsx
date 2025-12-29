import React, { useEffect } from "react";
import Layout from "@layouts/Layout";
import Block from "@blocks/Block";
import Conference from "@blocks/ConferenceBlock";

export default function Page({
    meta,
    data,
    navigationItems,
    breadcrumbs,
    showBreadcrumbs,
    showHeaders,
    newsPages,
    executiveCommitteeMembers,
    advisoryBoardMembers,
    members,
    preview,
}) {
    const { blocks, type, conference } = data;

    const conferencePage = type === "conferences" && conference;

    useEffect(() => {
        if (!preview) return;

        const interval = setInterval(() => {
            window.location.reload();
        }, 5000);

        return () => clearInterval(interval);
    }, [preview]);

    return (
        <Layout
            meta={meta}
            data={data}
            navigationItems={navigationItems}
            breadcrumbs={breadcrumbs}
            showBreadcrumbs={showBreadcrumbs}
            showHeaders={showHeaders}
        >
            {conferencePage && <Conference conference={conference} />}
            {blocks &&
                blocks.map((item, index) => (
                    <Block
                        key={index}
                        item={item}
                        newsPages={newsPages}
                        executiveCommitteeMembers={executiveCommitteeMembers}
                        advisoryBoardMembers={advisoryBoardMembers}
                        members={members}
                    />
                ))}
        </Layout>
    );
}
