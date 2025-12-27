import React, { useEffect } from "react";
import Layout from "@layouts/Layout";
import Block from "@blocks/Block";

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
    preview,
}) {
    const { blocks } = data;

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
            {blocks &&
                blocks.map((item, index) => (
                    <Block
                        key={index}
                        item={item}
                        newsPages={newsPages}
                        executiveCommitteeMembers={executiveCommitteeMembers}
                        advisoryBoardMembers={advisoryBoardMembers}
                    />
                ))}
        </Layout>
    );
}
