import React, { useEffect } from "react";
import Layout from "@layouts/Layout";
import Block from "@blocks/Block";
import Conference from "@blocks/ConferenceBlock";
import CallForPapers from "@blocks/CallForPapersBlock";

export default function Page({
    meta,
    data,
    navigationItems,
    breadcrumbs,
    showBreadcrumbs,
    showHeaders,
    newsPages,
    conferencesPages,
    callForPapersPages,
    executiveCommitteeMembers,
    advisoryBoardMembers,
    members,
    preview,
}) {
    const { blocks, type, conference, call_for_papers } = data;

    const conferencePage = type === "conferences" && conference;
    const callForPapersPage = type === "call-for-papers" && call_for_papers;

    // console.log(type);

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
            {callForPapersPage && (
                <CallForPapers callForPapers={call_for_papers} />
            )}

            {blocks &&
                blocks.map((item, index) => (
                    <Block
                        key={index}
                        item={item}
                        newsPages={newsPages}
                        conferencesPages={conferencesPages}
                        callForPapersPages={callForPapersPages}
                        executiveCommitteeMembers={executiveCommitteeMembers}
                        advisoryBoardMembers={advisoryBoardMembers}
                        members={members}
                    />
                ))}
        </Layout>
    );
}
